<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YouTubeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CommentController;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [YouTubeController::class, 'index'])->name('youtube.index');
Route::get('/trending', [YouTubeController::class, 'trending'])->name('youtube.trending');
Route::get('/watch/{videoId}', [YouTubeController::class, 'show'])->name('youtube.show');
Route::get('/load-more', [YouTubeController::class, 'loadMore'])->name('youtube.loadMore');

// Search route
Route::get('/search', [YouTubeController::class, 'search'])->name('youtube.search');

// Public comment routes
Route::get('/videos/{videoId}/comments', [CommentController::class, 'index'])->name('comments.index');

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
        Route::get('/comments', [ProfileController::class, 'myComments'])->name('profile.comments');
    });
    
    // Like & Subscribe AJAX routes
    Route::post('/like/toggle', [LikeController::class, 'toggle'])->name('like.toggle');
    Route::post('/subscribe/toggle', [SubscriptionController::class, 'toggle'])->name('subscribe.toggle');
    
    // Check subscription status
    Route::get('/subscription/check/{channelId}', [SubscriptionController::class, 'check'])->name('subscription.check');
    
    // Comment routes
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    
    // Subscriptions feed page (channel yang di-subscribe)
    Route::get('/subscriptions', [YouTubeController::class, 'subscriptionsFeed'])->name('youtube.subscriptions');
    
    // Save video to watch later
    Route::post('/video/save', [YouTubeController::class, 'saveVideo'])->name('video.save');
});

// ==================== ALIAS ROUTES ====================
Route::get('/home', function() {
    return redirect()->route('youtube.index');
})->name('home');