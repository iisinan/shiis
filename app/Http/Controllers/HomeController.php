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
        $images = Gallery::where('is_published', true)->latest()->get();
        return view('gallery.index', compact('images'));
    }

    public function dashboard()
    {
        try {
            return view('dashboard')->render();
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'type' => get_class($e),
                'trace' => collect($e->getTrace())->take(5)
            ], 500);
        }
    }

    public function debugLogs()
    {
        $info = [];
        
        // Check DB
        try {
            \DB::connection()->getPdo();
            $info['db_connection'] = 'OK';
            $info['tables'] = [
                'users' => \Schema::hasTable('users'),
                'roles' => \Schema::hasTable('roles'),
                'payments' => \Schema::hasTable('payments'),
                'elections' => \Schema::hasTable('elections'),
            ];
        } catch (\Exception $e) {
            $info['db_error'] = $e->getMessage();
        }

        // Check Logs
        if (file_exists(storage_path('logs/laravel.log'))) {
            $info['log_file'] = 'exists';
        } else {
            $files = scandir(storage_path('logs'));
            $info['log_folder_files'] = $files;
        }

        return response()->json($info);
    }
}
