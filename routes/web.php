<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', [PostController::class, 'index'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| ROUTE LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | POSTING CURHATAN
    |--------------------------------------------------------------------------
    */

    Route::post('/post', [PostController::class, 'store'])
        ->name('post.store');

    Route::post('/post/{post}/react', [ReactionController::class, 'toggle'])
        ->name('reaction.toggle');

    Route::post('/post/{post}/comment', [CommentController::class, 'store'])
        ->name('comment.store');

    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])
        ->name('comment.destroy');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get('/admin', function () {

        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return "HALAMAN ADMIN";

    })->name('admin');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';