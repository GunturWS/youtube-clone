<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YouTubeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;

// ==================== YOUTUBE ROUTES ====================
Route::get('/', [YouTubeController::class, 'index'])->name('youtube.index');
Route::get('/search', [YouTubeController::class, 'search'])->name('youtube.search');
Route::get('/watch/{videoId}', [YouTubeController::class, 'show'])->name('youtube.show');
Route::get('/trending', [YouTubeController::class, 'trending'])->name('youtube.trending');
Route::get('/subscriptions', function () {
    return view('youtube.subscriptions');
})->name('youtube.subscriptions');

// AJAX infinite scroll
Route::get('/load-more', [YouTubeController::class, 'loadMore'])->name('youtube.loadMore');

// ==================== AUTH ROUTES ====================
// Guest routes (only accessible when NOT logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
     // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== ALIAS ROUTES (OPTIONAL) ====================
// Jika Anda ingin juga punya route 'home' sebagai alias
Route::get('/home', function() {
    return redirect()->route('youtube.index');
})->name('home');

// Atau langsung arahkan ke controller yang sama
// Route::get('/home', [YouTubeController::class, 'index'])->name('home');