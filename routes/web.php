<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return redirect()->route('home');
});

// ✅ Routes d’auth Laravel UI (login, register, logout, etc.)
Auth::routes();

// ✅ Routes protégées
Route::middleware('auth')->group(function () {
    // Posts (home/feed)
    Route::get('/home', [PostController::class, 'index'])->name('home');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
 Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
         ->name('posts.comments.store');
    
    // Supprimer un commentaire
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
         ->name('comments.destroy');
    
    // Likes sur les commentaires
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])
         ->name('comments.like');

});
