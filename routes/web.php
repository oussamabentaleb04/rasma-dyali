<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\PatternController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/gallery', [PatternController::class, 'gallery'])->name('patterns.gallery');
Route::get('/patterns/{pattern}', [PatternController::class, 'show'])->name('patterns.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/my-dashboard', [DashboardController::class, 'user'])
        ->name('user.dashboard')
        ->middleware('role:user,admin');

    Route::get('/generator', [GeneratorController::class, 'index'])->name('generator.index');
    Route::post('/generator', [GeneratorController::class, 'store'])->name('patterns.store');

    Route::get('/my-patterns', [PatternController::class, 'mine'])->name('patterns.mine');
    Route::delete('/patterns/{pattern}', [PatternController::class, 'destroy'])->name('patterns.destroy');
    Route::post('/patterns/{pattern}/like', [PatternController::class, 'like'])->name('patterns.like');

    Route::get('/admin', [DashboardController::class, 'admin'])
        ->name('admin.dashboard')
        ->middleware('role:admin');
});