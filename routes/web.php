<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/index', [PostController::class, 'index']);
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/searchpage', [SearchController::class, 'index'])->name('search.index');

Route::prefix('posts')->group(function () {
    Route::get('{post}', [PostController::class, 'show'])->name('post.show');
    Route::post('/', [PostController::class, 'newpost'])->name('posts');
    Route::post('{id}/like', [PostController::class, 'like'])->name('posts.like');
    Route::put('{post}', [PostController::class, 'update'])->name('update.post');
    Route::delete('{post}', [PostController::class, 'destroy'])->name('delete.post');
    Route::post('{post}/comment', [PostController::class, 'commentPost'])->name('comment.post');

});


Route::post('/comments', [CommentController::class, 'comment'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


Route::prefix('users')->group(function(){
    Route::get('{id}', [UserController::class, 'index'])->name('profile.index');
});

Route::prefix('profile')->group(function(){
    Route::get('edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::post('/block/{user}', [UserController::class, 'blockUser'])->name('block.user');
Route::post('/unblock/{user}', [UserController::class, 'unblockUser'])->name('unblock.user');

Route::post('/follow/{user}', [ProfileController::class, 'follow'])->name('follow');
Route::post('/follow-request/accept/{followRequest}', [ProfileController::class, 'acceptFollowRequest'])->name('follow.accept');
Route::post('/follow-request/decline/{followRequest}', [ProfileController::class, 'declineFollowRequest'])->name('follow.decline');
Route::delete('/unfollow/{user}', [ProfileController::class, 'unfollow'])->name('unfollow');


Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/mentions/{mention}', [NotificationController::class, 'showMentionedComment'])->name('mentions.comment');

// Auth kontrolörleri
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
