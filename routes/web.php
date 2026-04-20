<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Moderator\DashboardController as ModeratorDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;

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
    
    // Likes et commentaires
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    
    // Supprimer un commentaire
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // Signaler un commentaire
    Route::post('/comments/{comment}/report', [CommentController::class, 'report'])->name('comments.report');
    
    // Likes sur les commentaires
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');

    // ========== REDIRECTION VERS LE BON DASHBOARD ==========
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'moderator') {
            return redirect()->route('moderator.dashboard');
        } else {
            return redirect()->route('home');
        }
    })->name('dashboard');
});

// Routes pour ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [App\Http\Controllers\Admin\DashboardController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\DashboardController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\DashboardController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\DashboardController::class, 'deleteUser'])->name('users.delete');
    Route::get('/posts', [App\Http\Controllers\Admin\DashboardController::class, 'posts'])->name('posts');
    Route::delete('/posts/{post}', [App\Http\Controllers\Admin\DashboardController::class, 'deletePost'])->name('posts.delete');
    Route::get('/reports', [App\Http\Controllers\Admin\DashboardController::class, 'reports'])->name('reports');
    Route::delete('/reports/{comment}', [App\Http\Controllers\Admin\DashboardController::class, 'deleteReportedComment'])->name('reports.delete');
});

// Routes pour MODERATOR
Route::middleware(['auth', 'moderator'])->prefix('moderator')->name('moderator.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Moderator\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/comments/reported', [App\Http\Controllers\Moderator\DashboardController::class, 'reportedComments'])->name('comments.reported');
    Route::delete('/comments/{comment}', [App\Http\Controllers\Moderator\DashboardController::class, 'deleteComment'])->name('comments.delete');
    Route::post('/comments/{comment}/ignore', [App\Http\Controllers\Moderator\DashboardController::class, 'ignoreReport'])->name('comments.ignore');
    Route::get('/reports', [App\Http\Controllers\Moderator\DashboardController::class, 'reports'])->name('reports');
});

// Routes pour USER NORMAL
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-posts', [UserDashboardController::class, 'myPosts'])->name('my-posts');
    Route::get('/my-comments', [UserDashboardController::class, 'myComments'])->name('my-comments');
});