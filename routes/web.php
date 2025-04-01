<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/email', function () { 
    $data['group'] = Group::first();
    $data['admin'] = User::first();
    $data['user'] = User::find(3);
    return view('emails.group-join-request-email', $data);
 })->name('email');

Route::get('/localization', [LocalizationController::class, 'index']);
Route::post('/switch-locale/{locale}', [LocalizationController::class, 'switchLocale'])->name('switch-locale');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Search
Route::get('search', [SearchController::class, 'search'])->name('search');

// Posts
Route::get('posts/{post}/single', [PostController::class, 'singlePost'])->name('posts.single');
Route::post('posts/{post}/like', [PostController::class, 'likePost'])->name('posts.like');
Route::resource('posts', PostController::class);
Route::post('posts/comments/{comment}/reply', [CommentController::class, 'replyComment'])->name('comments.reply');
Route::post('posts/comments/{comment}/like', [CommentController::class, 'likeComment'])->name('comments.like');
Route::resource('posts.comments', CommentController::class)->shallow();

// Groups
Route::put('groups/{group}/upload-avatar', [GroupController::class, 'uploadAvatar'])->name('groups.upload-avatar');
Route::put('groups/{group}/upload-cover', [GroupController::class, 'uploadCover'])->name('groups.upload-cover');
Route::post('groups/{group}/invite-member', [GroupController::class, 'inviteMember'])->name('groups.invite');
Route::post('groups/{group}/accept-invitation', [GroupController::class, 'acceptInvitation'])->name('groups.invitation.accept');
Route::post('groups/{group}/decline-invitation', [GroupController::class, 'declineInvitation'])->name('groups.invitation.decline');
Route::post('groups/{group}/join', [GroupController::class, 'joinGroup'])->name('groups.join');
Route::post('groups/{group}/leave', [GroupController::class, 'leaveGroup'])->name('groups.leave');
Route::post('groups/{group}/approve', [GroupController::class, 'approveMember'])->name('groups.approve');
Route::post('groups/{group}/reject', [GroupController::class, 'rejectMember'])->name('groups.reject');
Route::post('groups/{group}/change-role', [GroupController::class, 'changeRole'])->name('groups.change-role');
Route::post('groups/{group}/remove-member', [GroupController::class, 'removeMember'])->name('groups.remove-member');
Route::get('groups/{group}/posts', [GroupController::class, 'posts'])->name('groups.posts');
Route::resource('groups', GroupController::class);

// Profile
Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/{username}/posts', [ProfileController::class, 'posts'])->name('profile.posts');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/{username}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{username}', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/{username}/follow-toggle', [ProfileController::class, 'followToggle'])->name('profile.follow-toggle');
    Route::delete('/profile/{username}', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
