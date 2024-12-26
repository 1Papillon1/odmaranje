<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Početna stranica za goste
    Route::get('/', [AuthController::class, 'home'])->name('guest.home');


// Gost rute
Route::prefix('guest')->group(function () {
    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('guest.login');
    Route::post('/login', [AuthController::class, 'login'])->name('guest.login-post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('guest.register');
    Route::post('/register', [AuthController::class, 'register'])->name('guest.register-post');
});

// Korisničke rute (zaštitene 'auth' middleware-om)
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/stats', [UserController::class, 'stats'])->name('user.stats');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/coins', [UserController::class, 'coins'])->name('user.coins');
    Route::get('/achievements', [UserController::class, 'achievements'])->name('user.achievements');
    Route::get('/faq', [UserController::class, 'faq'])->name('user.faq');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Ova ruta omogućena za autentifikovane korisnike
});
