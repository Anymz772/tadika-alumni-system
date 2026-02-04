<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AlumniRegisterController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});


// Public Registration (for alumni)
Route::middleware('guest')->group(function () {
    Route::get('/register/alumni', [AlumniRegisterController::class, 'create'])->name('alumni.register');
    Route::post('/register/alumni', [AlumniRegisterController::class, 'store']);
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

    // Admin Survey Management Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/surveys', [SurveyController::class, 'index'])->name('survey.index');
        Route::get('/admin/surveys/{survey}', [SurveyController::class, 'show'])->name('survey.show');
        Route::post('/admin/surveys/{survey}/approve', [SurveyController::class, 'approve'])->name('survey.approve');
        Route::post('/admin/surveys/{survey}/reject', [SurveyController::class, 'reject'])->name('survey.reject');
        Route::delete('/admin/surveys/{survey}', [SurveyController::class, 'destroy'])->name('survey.destroy');
    });

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

// Simple public homepage
Route::get('/', function () {
    return view('home');
});

// Public Survey Routes (ONLY registration method)
Route::get('/survey', [SurveyController::class, 'create'])->name('survey.create');
Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
Route::get('/survey/thankyou', [SurveyController::class, 'thankyou'])->name('survey.thankyou');

// Authentication routes (from Laravel Breeze)
require __DIR__ . '/auth.php';
