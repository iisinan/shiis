<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NominationController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdminAgendaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    $images = \App\Models\Gallery::where('is_published', true)->latest()->get();
    return view('welcome', compact('images'));
});

Route::get('/agenda', function () {
    $agendas = \App\Models\Agenda::orderBy('order')->get();
    return view('agenda', compact('agendas'));
})->name('agenda');
Route::get('/gallery', function () {
    $images = \App\Models\Gallery::where('is_published', true)->latest()->get();
    return view('gallery.index', compact('images'));
})->name('gallery');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['paid'])->group(function () {
        Route::resource('nominations', NominationController::class)->only(['index', 'store', 'destroy']);
        Route::get('/elections', [ElectionController::class, 'index'])->name('elections.index');
        Route::post('/elections/{election}/vote', [ElectionController::class, 'vote'])->name('elections.vote');
        Route::get('/elections/results', [ElectionController::class, 'results'])->name('elections.results');
        
        Route::post('/payment/additional', [PaymentController::class, 'storeManual'])->name('payment.storeAdditional');
        
        Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
        Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
        Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

        Route::get('/members', [\App\Http\Controllers\MemberController::class, 'index'])->name('members.index');
        Route::get('/members/{user}', [\App\Http\Controllers\MemberController::class, 'show'])->name('members.show');
        
        Route::get('/members/search', function (Request $request) {
            return \App\Models\User::where('name', 'like', '%' . $request->q . '%')
                ->where('id', '!=', auth()->id())
                ->limit(10)
                ->get(['id', 'name']);
        })->name('members.search');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:Super Admin|Election Admin|Finance Admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard', [
            'links' => '<div class="flex flex-wrap gap-4">
                        <a href="'.route('admin.members').'" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Manage Members</a>
                        <a href="'.route('admin.nominations').'" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition">Review Nominations</a>
                        <a href="'.route('admin.agenda.index').'" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition">Manage Agenda</a>
                        <a href="'.route('admin.gallery.index').'" class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition">Manage Gallery</a>
                        <button class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">Election Controls</button>
                    </div>'
        ]);
    })->name('admin.dashboard');

    Route::get('/admin/members', [AdminController::class, 'members'])->name('admin.members');
    Route::post('/admin/members/{user}/verify', [AdminController::class, 'verifyPayment'])->name('admin.members.verify');
    
    Route::get('/admin/nominations', [AdminController::class, 'nominations'])->name('admin.nominations');
    Route::post('/admin/nominations/{nomination}/approve', [AdminController::class, 'approveNomination'])->name('admin.nominations.approve');
    
    Route::post('/admin/elections/{election}/toggle', [AdminController::class, 'toggleElection'])->name('admin.elections.toggle');

    Route::get('/admin/logs', [AdminController::class, 'activityLogs'])->name('admin.logs');
    
    Route::get('/admin/announcements', [AnnouncementController::class, 'index'])->name('admin.announcements.index');
    Route::post('/admin/announcements', [AnnouncementController::class, 'store'])->name('admin.announcements.store');
    Route::post('/admin/announcements/{announcement}/toggle', [AnnouncementController::class, 'toggle'])->name('admin.announcements.toggle');
    Route::delete('/admin/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');

    Route::get('/admin/agenda', [AdminAgendaController::class, 'index'])->name('admin.agenda.index');
    Route::post('/admin/agenda', [AdminAgendaController::class, 'store'])->name('admin.agenda.store');
    Route::put('/admin/agenda/{agenda}', [AdminAgendaController::class, 'update'])->name('admin.agenda.update');
    Route::delete('/admin/agenda/{agenda}', [AdminAgendaController::class, 'destroy'])->name('admin.agenda.destroy');
});

Route::middleware(['auth', 'verified', 'role:Accountant|Super Admin'])->group(function () {
    Route::get('/accountant/dashboard', [AccountantController::class, 'dashboard'])->name('accountant.dashboard');
    Route::get('/accountant/export', [AccountantController::class, 'exportVerifiedPayments'])->name('accountant.export');
    Route::post('/accountant/verify/{user}', [AccountantController::class, 'verifyPayment'])->name('accountant.verify');
});

require __DIR__.'/auth.php';
