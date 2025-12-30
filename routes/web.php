<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YouTubeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SubscriptionController;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [YouTubeController::class, 'index'])->name('youtube.index');
Route::get('/trending', [YouTubeController::class, 'trending'])->name('youtube.trending');
Route::get('/watch/{videoId}', [YouTubeController::class, 'show'])->name('youtube.show');
Route::get('/load-more', [YouTubeController::class, 'loadMore'])->name('youtube.loadMore');

// ==================== AUTH ROUTES ====================
// Guest routes (only accessible when NOT logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// ==================== PROTECTED ROUTES (require authentication) ====================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
        // Profile sections
        Route::get('/likes', [ProfileController::class, 'likedVideos'])->name('profile.likes');
        Route::get('/subscriptions', [ProfileController::class, 'subscriptions'])->name('profile.subscriptions');
        Route::get('/history', [ProfileController::class, 'history'])->name('profile.history');
    });
    
    // Like & Subscribe AJAX routes
    Route::post('/like/toggle', [LikeController::class, 'toggle'])->name('like.toggle');
    Route::post('/subscribe/toggle', [SubscriptionController::class, 'toggle'])->name('subscribe.toggle');
    
    // Subscriptions feed (channel yang di-subscribe)
    Route::get('/feed/subscriptions', [YouTubeController::class, 'subscriptionsFeed'])->name('youtube.subscriptions');
    
    // Save video to watch later / playlist
    Route::post('/video/save', [YouTubeController::class, 'saveVideo'])->name('video.save');
});

// ==================== OPTIONAL: SEARCH ROUTE ====================
// Jika controller Anda punya method search (dari sebelumnya)
Route::get('/search', [YouTubeController::class, 'search'])->name('youtube.search');

// ==================== ALIAS ROUTES ====================
Route::get('/home', function() {
    return redirect()->route('youtube.index');
})->name('home');