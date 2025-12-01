<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserAuthController;

/**/

Route::get('/', fn() => view('auth.login'))->name('login');

Route::post('/login', [UserAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

Route::get('/app', fn() => view('layouts.app'))
    ->middleware('auth')
    ->name('app');


// Route::get('/', fn() => view('auth.login'))->name('home');
// Route::post('/login', [UserAuthController::class, 'login'])->name('login.post');
// Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

// Route::get('/app', fn() => view('layouts.app'))
//     ->middleware('auth')
//     ->name('app');

Route::post('/uploads/images', [PostController::class, 'uploadImage'])
    ->middleware('auth')
    ->name('uploads.images');




Route::middleware(['auth', 'role:user,admin'])->group(function () {

    Route::get('/search/posts', [PostController::class, 'search'])->name('posts.search');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    
    Route::resource('comments', CommentController::class)->only(['store', 'destroy']);

    Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories', [CategoryController::class, 'indexAdmin'])->name('categories.user.index');
});



Route::middleware(['role:admin'])->prefix('is_admin')->name('is_admin.')->group(function () {
// Route::middleware(['is_admin'])->group( function () {
    Route::get('/categories', [CategoryController::class, 'indexAdmin'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('categories.delete');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{user}/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])->name('users.delete');
});
