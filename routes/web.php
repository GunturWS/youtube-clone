<?php

use App\Http\Controllers\YouTubeController;

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