<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

use App\Http\Controllers\GoogleController;

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

//Tasks management routes
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // 1. Dashboard route points to your controller's index
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');

    // 2. Resource route for CRUD operations
    Route::resource('tasks', TaskController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
});

