<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YouTubeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// YouTube Routes
Route::get('/', [YouTubeController::class, 'index'])->name('youtube.index');
Route::get('/search', [YouTubeController::class, 'search'])->name('youtube.search');
Route::get('/watch/{videoId}', [YouTubeController::class, 'show'])->name('youtube.show');
Route::get('/trending', [YouTubeController::class, 'trending'])
    ->name('youtube.trending');
Route::get('/subscriptions', function () {
    return view('youtube.subscriptions');
})->name('youtube.subscriptions');

// 🔥 AJAX infinite scroll
Route::get('/load-more', [YouTubeController::class, 'loadMore'])
    ->name('youtube.loadMore');

// ============================
// AUTH ROUTES (TAMBAHKAN INI)
// ============================

// Auth routes for guests only
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Anda bisa menambahkan route yang memerlukan login di sini
    // Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});