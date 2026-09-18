<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::post('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
});
