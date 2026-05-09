<?php

namespace App\Http\Controllers;

use App\Models\Nomination;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditLogger;

class NominationController extends Controller
{
    public function index()
    {
        $isActive = \Illuminate\Support\Facades\Cache::get('nominations_active', false);

        if (!$isActive) {
            $eventDate = \Carbon\Carbon::parse('2026-05-31');
            $nominationDate = $eventDate->copy()->subDay()->startOfDay();

            return view('nominations.coming-soon', [
                'activeDate' => 'Subject to Admin Activation',
                'rawDate' => $nominationDate->format('Y-m-d H:i:s'),
                'daysToWait' => max(0, now()->diffInDays($nominationDate, false))
            ]);
        }

        // Get current user's nominations
        $myNominations = Nomination::where('nominator_id', Auth::id())
            ->get()
            ->keyBy('position');

        $positions = [
            'Chairman', 'Vice Chairman', 'Secretary', 'Assistant Secretary',
            'Treasurer', 'Financial Secretary', 'PRO', 'Welfare Officer', 'Social/Event Coordinator'
        ];

        // Only allow nominating members who are NOT the current user
        $users = User::where('id', '!=', Auth::id())->orderBy('name')->get();

        return view('nominations.index', compact('myNominations', 'positions', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nominees' => 'required|array',
            'nominees.*' => 'nullable|exists:users,id',
        ]);

        $count = 0;
        foreach ($request->nominees as $position => $nomineeId) {
            if (!$nomineeId) continue;

            // Check if user already nominated for this position
            $existing = Nomination::where('nominator_id', Auth::id())
                ->where('position', $position)
                ->first();

            if ($existing) {
                // Update if it's still pending
                if ($existing->status === 'pending') {
                    $existing->update(['nominee_id' => $nomineeId]);
                    $count++;
                }
            } else {
                Nomination::create([
                    'nominator_id' => Auth::id(),
                    'nominee_id' => $nomineeId,
                    'position' => $position,
                    'reason' => 'Unified nomination', // Default since reason was removed from UI
                    'status' => 'pending',
                ]);
                $count++;
            }
        }

        if ($count > 0) {
            AuditLogger::log('Bulk Nomination', "User nominated members for {$count} executive positions.");
            
            // Notify Election Admins
            try {
                $admins = User::role(['Super Admin', 'Election Admin'])->get();
                foreach ($admins as $admin) {
                    \Illuminate\Support\Facades\Mail::to($admin->email)
                        ->send(new \App\Mail\NewNominationAdminMail(Auth::user(), User::find(reset($request->nominees)), 'Multiple Positions'));
                }
            } catch (\Exception $e) {
                // Silently fail mail
            }

            return redirect()->route('nominations.index')->with('success', 'Your executive team nominations have been saved.');
        }

        return back()->with('info', 'No new nominations were submitted.');
    }

    public function destroy(Nomination $nomination)
    {
        if ($nomination->nominator_id !== Auth::id()) {
            abort(403);
        }

        if ($nomination->status !== 'pending') {
            return back()->with('error', 'Only pending nominations can be withdrawn.');
        }

        $pos = $nomination->position;
        $nomination->delete();

        AuditLogger::log('Nomination Withdrawal', "User withdrew their nomination for {$pos}");

        return redirect()->route('nominations.index')->with('success', 'Nomination withdrawn successfully.');
    }
}
