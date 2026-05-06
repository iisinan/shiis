<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_active', true)->where('is_paid', true);

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nickname', 'like', '%' . $request->search . '%')
                  ->orWhere('occupation', 'like', '%' . $request->search . '%');
            });
        }

        $members = $query->orderBy('name')->paginate(12);

        return view('members.index', compact('members'));
    }

    public function show(User $user)
    {
        if (!$user->is_paid) {
            abort(404);
        }

        return view('members.show', compact('user'));
    }

    public function search(Request $request)
    {
        return User::where('name', 'like', '%' . $request->q . '%')
            ->where('id', '!=', auth()->id())
            ->limit(10)
            ->get(['id', 'name']);
    }
}
