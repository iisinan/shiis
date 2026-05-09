<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\Nomination;
use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Http\Request;

use App\Services\AuditLogger;

class AdminController extends Controller
{
    public function members()
    {
        $members = User::with(['payments'])->latest()->paginate(20);
        return view('admin.members.index', compact('members'));
    }

    public function destroyMember(User $user)
    {
        if ($user->hasRole('Super Admin')) {
            return back()->with('error', 'Cannot delete a Super Admin.');
        }

        $name = $user->name;
        $user->delete();

        AuditLogger::log('Member Deletion', "Admin deleted member: {$name}");

        return back()->with('success', "Member {$name} deleted successfully.");
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        AuditLogger::log('Password Reset', "Admin reset password for {$user->name}");

        return back()->with('success', "Password for {$user->name} has been reset successfully.");
    }

    public function verifyPayment(Request $request, User $user)
    {
        $user->update([
            'is_paid' => true,
            'is_active' => true,
        ]);

        $payment = $user->payments()->where('status', 'pending')->latest()->first();
        if ($payment) {
            $payment->update(['status' => 'success']);
        }

        AuditLogger::log('Payment Verified', "Admin verified payment for {$user->name}");

        \Illuminate\Support\Facades\Mail::to($user->email)->queue(new \App\Mail\PaymentVerifiedMail($user));

        return back()->with('success', "Member {$user->name} has been verified and activated.");
    }

    public function nominations()
    {
        $nominations = Nomination::with(['nominator', 'nominee'])->latest()->get();
        return view('admin.nominations.index', compact('nominations'));
    }

    public function approveNomination(Request $request, Nomination $nomination)
    {
        $nomination->update(['status' => 'approved']);
        
        $election = Election::where('is_active', true)->first();
        
        if ($election) {
            Candidate::firstOrCreate([
                'election_id' => $election->id,
                'user_id' => $nomination->nominee_id,
                'position' => $nomination->position,
            ], [
                'manifesto' => $nomination->reason,
                'status' => 'approved',
            ]);
        }

        AuditLogger::log('Nomination Approved', "Admin approved nomination for {$nomination->nominee->name} as {$nomination->position}");

        // Notify the nominee
        try {
            \Illuminate\Support\Facades\Mail::to($nomination->nominee->email)
                ->queue(new \App\Mail\NominationApprovedMail($nomination->nominee, $nomination->position));
        } catch (\Exception $e) {
            \App\Services\AuditLogger::log('Email Failure', "Failed to notify nominee {$nomination->nominee->email}");
        }

        return back()->with('success', 'Nomination approved. If an election is active, they have been added as a candidate.');
    }

    public function initializeElection()
    {
        // Don't initialize if one already exists
        if (\App\Models\Election::where('is_active', true)->exists()) {
            return back()->with('error', 'An active election already exists.');
        }

        $election = \App\Models\Election::create([
            'title' => 'SHIIS \'05 Executive Election',
            'start_date' => now(),
            'end_date' => now()->addDays(2),
            'is_active' => true,
        ]);

        // Sync all approved nominations to this new election
        $this->syncCandidates($election);

        \App\Services\AuditLogger::log('Election Opened', "Election '{$election->title}' was initialized and opened.");
        return back()->with('success', 'New election created and opened successfully with all approved candidates.');
    }

    public function toggleElection(Election $election)
    {
        $newState = !$election->is_active;
        $election->update(['is_active' => $newState]);

        if ($newState) {
            // Opening election - sync candidates
            $this->syncCandidates($election);
            $msg = 'Election opened successfully with all approved candidates.';
            AuditLogger::log('Election Opened', "Election '{$election->title}' was opened.");
        } else {
            // Election was just closed. Compile results and send emails.
            $results = \App\Models\Vote::where('election_id', $election->id)
                ->select('position', 'candidate_id', \DB::raw('count(*) as total_votes'))
                ->groupBy('position', 'candidate_id')
                ->with('candidate.user')
                ->get()
                ->groupBy('position');

            $users = \App\Models\User::where('is_active', true)->where('is_paid', true)->get();
            
            foreach ($users as $user) {
                try {
                    \Illuminate\Support\Facades\Mail::to($user->email)->queue(new \App\Mail\ElectionResultMail($election, $results));
                } catch (\Exception $e) {
                    \App\Services\AuditLogger::log('Email Failure', "Failed to send election results to {$user->email}");
                }
            }

            $msg = 'Election closed and results broadcasted to all members.';
            \App\Services\AuditLogger::log('Election Closed', "Election '{$election->title}' was closed and results broadcasted.");
        }

        return back()->with('success', $msg);
    }

    private function syncCandidates(Election $election)
    {
        $approvedNominations = Nomination::where('status', 'approved')->get();
        
        foreach ($approvedNominations as $nom) {
            Candidate::firstOrCreate([
                'election_id' => $election->id,
                'user_id' => $nom->nominee_id,
                'position' => $nom->position,
            ], [
                'manifesto' => $nom->reason,
                'status' => 'approved',
            ]);
        }
    }

    public function toggleNominations()
    {
        $currentState = \Illuminate\Support\Facades\Cache::get('nominations_active', false);
        \Illuminate\Support\Facades\Cache::forever('nominations_active', !$currentState);
        
        $status = !$currentState ? 'opened' : 'closed';
        AuditLogger::log('Nomination Status', "Admin {$status} nominations globally.");

        return back()->with('success', "Nominations are now {$status}.");
    }

    public function systemReset(Request $request)
    {
        // Require explicit confirmation keyword for safety
        if ($request->keyword !== 'RESET-ALL') {
            return back()->with('error', 'Invalid confirmation keyword. System reset aborted.');
        }

        // Wipe Database and Reseed
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true
        ]);

        // Clear Uploaded Files
        \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->deleteDirectory('receipts');
        \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->deleteDirectory('gallery');

        // Clear Cache
        \Illuminate\Support\Facades\Cache::flush();

        // Redirect to login because their session is dropped
        return redirect()->route('login')->with('success', 'Nuclear Reset Complete. The system is completely fresh. Please log in with the default admin credentials.');
    }

    public function activityLogs()
    {
        $logs = \App\Models\AuditLog::with('user')->latest()->paginate(50);
        return view('admin.logs.index', compact('logs'));
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'links' => '<div class="flex flex-wrap gap-4">
                        <a href="'.route('admin.members').'" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Manage Members</a>
                        <a href="'.route('admin.nominations').'" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition">Review Nominations</a>
                        <a href="'.route('admin.agenda.index').'" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition">Manage Agenda</a>
                        <a href="'.route('admin.gallery.index').'" class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition">Manage Gallery</a>
                        <button class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">Election Controls</button>
                    </div>'
        ]);
    }
}
