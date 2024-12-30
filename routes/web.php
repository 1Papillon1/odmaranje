<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'home'])->name('guest.home');



Route::prefix('guest')->group(function () {
    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('guest.login');
    Route::post('/login', [AuthController::class, 'login'])->name('guest.login-post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('guest.register');
    Route::post('/register', [AuthController::class, 'register'])->name('guest.register-post');
});

Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/notifications', [UserController::class, 'notifications'])->name('user.notifications');
    Route::get('/coins', [UserController::class, 'coins'])->name('user.coins');
    Route::get('/achievements', [UserController::class, 'achievements'])->name('user.achievements');
    Route::get('/events', [UserController::class, 'events'])->name('user.events');
    Route::get('/calendar', [UserController::class, 'calendar'])->name('user.calendar');
    Route::get('/faq', [UserController::class, 'faq'])->name('user.faq');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 
});
