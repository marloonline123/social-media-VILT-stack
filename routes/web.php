<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\PostController;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/info', function () {
    return phpinfo();
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/localization', [LocalizationController::class, 'index']);
Route::post('/switch-locale/{locale}', [LocalizationController::class, 'switchLocale'])->name('switch-locale');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('posts/{post}/like', [PostController::class, 'likePost'])->name('posts.like');
Route::resource('posts', PostController::class);
Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('profile.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/{username}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{username}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{username}', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
