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
}
