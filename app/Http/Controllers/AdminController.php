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
        $election = Election::where('is_active', true)->first();
        
        if (!$election) {
            return back()->with('error', 'No active election found. Please create one first.');
        }

        Candidate::create([
            'election_id' => $election->id,
            'user_id' => $nomination->nominee_id,
            'position' => $nomination->position,
            'manifesto' => $nomination->reason, // Use nomination reason as initial manifesto
            'status' => 'approved',
        ]);

        $nomination->update(['status' => 'approved']);

        AuditLogger::log('Nomination Approved', "Admin approved nomination for {$nomination->nominee->name} as {$nomination->position}");

        return back()->with('success', 'Nomination approved and member is now a candidate.');
    }

    public function toggleElection(Election $election)
    {
        $election->update(['is_active' => !$election->is_active]);
        return back()->with('success', 'Election status updated.');
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
