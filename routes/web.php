<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NominationController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdminAgendaController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'welcome'])->name('home');

Route::get('/agenda', [HomeController::class, 'agenda'])->name('agenda');

Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');

// Fail-proof image server (Supports Local and R2)
Route::get('/gallery/image/{filename}', function ($filename) {
    $path = "gallery/{$filename}";
    $disk = \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'));
    
    if (!$disk->exists($path)) {
        \Illuminate\Support\Facades\Log::error("Image not found on disk (" . config('filesystems.default') . "): {$path}");
        abort(404);
    }

    $file = $disk->get($path);
    $type = $disk->mimeType($path);

    return response($file)->header('Content-Type', $type);
})->name('gallery.image');

// Temporary diagnostic route - will be removed after gallery is fixed
Route::get('/gallery-debug', function () {
    $total = \App\Models\Gallery::count();
    $images = \App\Models\Gallery::latest()->take(5)->get(['id', 'title', 'image_path', 'is_published', 'user_id', 'created_at']);

    $fileChecks = $images->map(function($img) {
        $path = $img->image_path;
        $publicExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
        $localExists  = \Illuminate\Support\Facades\Storage::disk('local')->exists($path);
        return [
            'id'           => $img->id,
            'image_path'   => $path,
            'basename'     => basename($path),
            'public_disk_file_exists' => $publicExists,
            'local_disk_file_exists'  => $localExists,
            'proxy_url'    => route('gallery.image', ['filename' => basename($path)]),
        ];
    });

    return response()->json([
        'total_in_db'         => $total,
        'storage_link_exists' => file_exists(public_path('storage')),
        'filesystem_disk'     => config('filesystems.default'),
        'files'               => $fileChecks,
    ], 200, [], JSON_PRETTY_PRINT);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::middleware(['paid'])->group(function () {
        Route::resource('nominations', NominationController::class)->only(['index', 'store', 'destroy']);
        Route::get('/elections', [ElectionController::class, 'index'])->name('elections.index');
        Route::post('/elections/{election}/vote', [ElectionController::class, 'vote'])->name('elections.vote');
        Route::get('/elections/results', [ElectionController::class, 'results'])->name('elections.results');

        Route::get('/members', [MemberController::class, 'index'])->name('members.index');
        Route::get('/members/{user}', [MemberController::class, 'show'])->name('members.show');
        Route::get('/members/search', [MemberController::class, 'search'])->name('members.search');
    });

    // Gallery is open to ALL authenticated members (not just paid)
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

    Route::post('/payment/additional', [PaymentController::class, 'storeManual'])->name('payment.storeAdditional');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:Super Admin|Election Admin|Finance Admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

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
    Route::get('/admin/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
});

Route::middleware(['auth', 'role:Accountant|Super Admin'])->group(function () {
    Route::get('/accountant/dashboard', [AccountantController::class, 'dashboard'])->name('accountant.dashboard');
    Route::get('/accountant/export', [AccountantController::class, 'exportVerifiedPayments'])->name('accountant.export');
    Route::post('/accountant/verify/{user}', [AccountantController::class, 'verifyPayment'])->name('accountant.verify');
});

require __DIR__.'/auth.php';
