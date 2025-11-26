<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendshipController;


Route::get('/', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);
Route::get(uri: '/logout', action: [SessionController::class, 'destroy'])->name(name: 'logout');

Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/reset-request', [PasswordResetController::class, 'resetRequest']);
Route::post('/send', [PasswordResetController::class, 'send']);
Route::get('/resetPassword', [PasswordResetController::class, 'reset']);
Route::post('/reset', [PasswordResetController::class, 'resetPassword']);

//search bar
Route::get('/search-users', [RegisteredUserController::class, 'search'])->name('search.users');

Route::get('/for-you', [PostController::class, 'foryou']
)->name('user.for-you');

Route::get('/profile',[ProfileController::class, 'profile']
)->name('user.profile');
Route::post('/edit',[ProfileController::class, 'editUser']);
Route::post('/upload',[ProfileController::class, 'upload']);

// searched users profile page
Route::get('/users/{id}', [RegisteredUserController::class, 'show'])->name('users.show');

Route::delete('/users/{user}', [RegisteredUserController::class, 'destroy'])->name('users.destroy');

Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
// adds a post to the database
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
// returns a page that shows a full post
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
// returns the form for editing a post
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
// updates a post
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
// deletes a post
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
//msgs
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'fetchMessages']);
    Route::post('/messages/send', [MessageController::class, 'sendMessage']);
    Route::get('/api/chat/history', [MessageController::class, 'getChatHistory']);
    Route::get('/api/friends/list', [MessageController::class, 'getFriends']);
    Route::get('/api/chat/unread-summary', [MessageController::class, 'getUnreadSummary']);
});

//friendship routes
Route::middleware('auth')->group(function () {
    Route::post('/friend/send/{id}', [FriendshipController::class, 'send'])->name('friend.send');
    Route::post('/friend/accept/{id}', [FriendshipController::class, 'accept'])->name('friend.accept');
    Route::post('/friend/deny/{id}', [FriendshipController::class, 'deny'])->name('friend.deny');
    Route::delete('/friend/remove/{id}', [FriendshipController::class, 'remove'])->name('friend.remove');
});

