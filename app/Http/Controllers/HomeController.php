<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Agenda;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function welcome()
    {
        $images = Gallery::where('is_published', true)->latest()->get();
        return view('welcome', compact('images'));
    }

    public function agenda()
    {
        $agendas = Agenda::orderBy('order')->get();
        return view('agenda', compact('agendas'));
    }

    public function gallery()
    {
        $images = Gallery::latest()->get();
        return view('gallery.index', compact('images'));
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
