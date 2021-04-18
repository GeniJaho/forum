<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/threads', [ThreadsController::class, 'index'])->name('threads.index');
Route::get('/threads/create', [ThreadsController::class, 'create'])->name('threads.create');
Route::get('/threads/{channel}/{thread}', [ThreadsController::class, 'show'])->name('threads.show');
Route::delete('/threads/{channel}/{thread}', [ThreadsController::class, 'destroy'])->name('threads.destroy');
Route::post('/threads', [ThreadsController::class, 'store'])->name('threads.store');
Route::get('/threads/{channel}', [ThreadsController::class, 'index'])->name('threads.channel');
Route::post('/threads/{channel}/{thread}/replies', [RepliesController::class, 'store'])->name('replies.store');
Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store'])->name('replies.favorite');
Route::delete('/replies/{reply}/favorites', [FavoritesController::class, 'destroy'])->name('replies.unfavorite');
Route::delete('/replies/{reply}', [RepliesController::class, 'destroy'])->name('replies.destroy');
Route::patch('/replies/{reply}', [RepliesController::class, 'update'])->name('replies.update');

Route::get('profiles/{user}', [ProfilesController::class, 'show'])->name('profile');
