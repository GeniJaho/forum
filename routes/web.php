<?php

use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\BestRepliesController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LockedThreadsController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use App\Http\Controllers\ThreadSubscriptionsController;
use App\Http\Controllers\UserAvatarController;
use App\Http\Controllers\UserNotificationsController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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


Auth::routes(['verify' => true]);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/threads', [ThreadsController::class, 'index'])->name('threads.index');
Route::get('/threads/create', [ThreadsController::class, 'create'])->name('threads.create');
Route::get('/threads/{channel}/{thread}', [ThreadsController::class, 'show'])->name('threads.show');
Route::patch('/threads/{channel}/{thread}', [ThreadsController::class, 'update'])->name('threads.update');
Route::delete('/threads/{channel}/{thread}', [ThreadsController::class, 'destroy'])->name('threads.destroy');
Route::post('/threads', [ThreadsController::class, 'store'])->name('threads.store')->middleware('verified');
Route::get('/threads/{channel}', [ThreadsController::class, 'index'])->name('threads.channel');

Route::post('locked-threads/{thread}', [LockedThreadsController::class, 'store'])
    ->name('locked-threads.store')
    ->middleware(['auth', 'admin']);
Route::delete('locked-threads/{thread}', [LockedThreadsController::class, 'destroy'])
    ->name('locked-threads.destroy')
    ->middleware(['auth', 'admin']);

Route::get('/threads/{channel}/{thread}/replies', [RepliesController::class, 'index'])->name('replies.index');
Route::post('/threads/{channel}/{thread}/replies', [RepliesController::class, 'store'])->name('replies.store');
Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store'])->name('replies.favorite');
Route::delete('/replies/{reply}/favorites', [FavoritesController::class, 'destroy'])->name('replies.unfavorite');
Route::delete('/replies/{reply}', [RepliesController::class, 'destroy'])->name('replies.destroy');
Route::patch('/replies/{reply}', [RepliesController::class, 'update'])->name('replies.update');

Route::post('/replies/{reply}/best', [BestRepliesController::class, 'store'])->name('best-replies.store');

Route::post('/threads/{channel}/{thread}/subscriptions', [ThreadSubscriptionsController::class, 'store'])
    ->middleware('auth')
    ->name('thread_subscriptions.store');
Route::delete('/threads/{channel}/{thread}/subscriptions', [ThreadSubscriptionsController::class, 'destroy'])
    ->middleware('auth')
    ->name('thread_subscriptions.destroy');

Route::get('profiles/{user}', [ProfilesController::class, 'show'])->name('profile');
Route::get('profiles/{user}/notifications', [UserNotificationsController::class, 'index'])->name('notifications.index');
Route::delete('profiles/{user}/notifications/{notification}', [UserNotificationsController::class, 'destroy'])->name('notifications.destroy');

Route::get('api/users', [UsersController::class, 'index']);
Route::post('api/users/{user}/avatar', [UserAvatarController::class, 'store'])
    ->name('avatar')
    ->middleware('auth');
