<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElectionController extends Controller
{
    public function index()
    {
        $eventDate = \Carbon\Carbon::parse('2026-05-31')->startOfDay();

        if (now()->lt($eventDate)) {
            return view('elections.coming-soon', [
                'activeDate' => $eventDate->format('F jS, Y'),
                'rawDate' => $eventDate->format('Y-m-d H:i:s'),
                'daysToWait' => now()->diffInDays($eventDate)
            ]);
        }

        $election = Election::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$election) {
            return view('elections.no-active');
        }

        $candidates = Candidate::with('user')
            ->where('election_id', $election->id)
            ->where('status', 'approved')
            ->get()
            ->groupBy('position');

        $userVotes = Vote::where('election_id', $election->id)
            ->where('user_id', Auth::id())
            ->pluck('position')
            ->toArray();

        return view('elections.index', compact('election', 'candidates', 'userVotes'));
    }

    public function vote(Request $request, Election $election)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $candidate = Candidate::findOrFail($request->candidate_id);

        // Security checks
        if (!Auth::user()->is_paid) {
            return back()->with('error', 'You must be a verified paid member to vote.');
        }

        if (!$election->is_active || now() < $election->start_date || now() > $election->end_date) {
            return back()->with('error', 'This election is not currently active.');
        }

        // Check if already voted for this position
        $existingVote = Vote::where('election_id', $election->id)
            ->where('user_id', Auth::id())
            ->where('position', $candidate->position)
            ->first();

        if ($existingVote) {
            return back()->with('error', 'You have already voted for the ' . $candidate->position . ' position.');
        }

        Vote::create([
            'election_id' => $election->id,
            'user_id' => Auth::id(),
            'candidate_id' => $candidate->id,
            'position' => $candidate->position,
        ]);

        return back()->with('success', 'Vote cast successfully for ' . $candidate->user->name . ' as ' . $candidate->position . '.');
    }

    public function results()
    {
        $election = Election::where('is_active', false)
            ->orWhere('end_date', '<', now())
            ->latest()
            ->first();

        if (!$election) {
            return back()->with('error', 'No election results available yet.');
        }

        $results = Vote::where('election_id', $election->id)
            ->select('position', 'candidate_id', \DB::raw('count(*) as total_votes'))
            ->groupBy('position', 'candidate_id')
            ->with('candidate.user')
            ->get()
            ->groupBy('position');

        return view('elections.results', compact('election', 'results'));
    }
}
