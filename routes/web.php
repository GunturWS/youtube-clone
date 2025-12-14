<?php

use App\Http\Controllers\YouTubeController;

Route::get('/', [YouTubeController::class, 'index'])->name('youtube.index');
Route::get('/search', [YouTubeController::class, 'search'])->name('youtube.search');
Route::get('/watch/{videoId}', [YouTubeController::class, 'show'])->name('youtube.show');


