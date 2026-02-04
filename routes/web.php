<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AlumniRegisterController;
use Illuminate\Support\Facades\Route;


// ================= PUBLIC REGISTRATION ROUTES =================
Route::get('/', function () {
    return view('home');
});

// Public Registration (for alumni)
Route::middleware('guest')->group(function () {
    Route::get('/register/alumni', [AlumniRegisterController::class, 'create'])->name('alumni.register');
    Route::post('/register/alumni', [AlumniRegisterController::class, 'store']);
    Route::get('/register/alumni/thankyou', [AlumniRegisterController::class, 'thankyou'])->name('alumni.register.thankyou');
});

// ================= LOGIN/DASHBOARD =================
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('profile.show');
})->middleware(['auth', 'verified'])->name('dashboard');

// ================= ADMIN ROUTES =================
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Alumni Management Routes (Standard RESTful routes)
    Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
    Route::get('/alumni/create', [AlumniController::class, 'create'])->name('alumni.create');
    Route::post('/alumni', [AlumniController::class, 'store'])->name('alumni.store');
    Route::get('/alumni/{alumni}', [AlumniController::class, 'show'])->name('alumni.show');
    Route::get('/alumni/{alumni}/edit', [AlumniController::class, 'edit'])->name('alumni.edit');
    Route::put('/alumni/{alumni}', [AlumniController::class, 'update'])->name('alumni.update');
    Route::delete('/alumni/{alumni}', [AlumniController::class, 'destroy'])->name('alumni.destroy');

    // Password Reset
    Route::post('/alumni/{alumni}/reset-password', [AlumniController::class, 'resetPassword'])
        ->name('alumni.reset-password');
});

// ================= ALUMNI PROFILE ROUTES =================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});



// Authentication routes (from Laravel Breeze)
require __DIR__ . '/auth.php';
