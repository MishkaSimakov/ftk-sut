<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::view('/', 'welcome')->name('main');

# news
Route::resource('news', \App\Http\Controllers\NewsController::class);

# articles
Route::get('article/unpublished', [\App\Http\Controllers\ArticleController::class, 'unpublished'])->name('article.unpublished');
Route::get('article/{article}/publish', [\App\Http\Controllers\ArticleController::class, 'publish'])->name('article.publish');
Route::resource('article', \App\Http\Controllers\ArticleController::class);

# events
Route::get('events/{event}/users/edit', [\App\Http\Controllers\EventsController::class, 'editUsersList'])->name('events.users.edit');
Route::resource('events', \App\Http\Controllers\EventsController::class);

# rating
Route::resource('rating', \App\Http\Controllers\RatingController::class)
    ->except('index', 'edit', 'update', 'show');
Route::get('rating/{period?}', [\App\Http\Controllers\RatingController::class, 'index'])
    ->name('rating.index')
    ->where('date', '[0-9]{4}\.[0-9]{2}\-[0-9]{4}\.[0-9]{2}');  // regex for 'YYYY.MM-YYYY.MM' query

//Route::prefix('statistics')->name('statistics.')->group(function () {
//    Route::get('compare/{user}', [\App\Http\Controllers\Statistics\StatisticsController::class, 'compare'])->name('compare');
//});

# other
Route::get('/clubs', [\App\Http\Controllers\ClubController::class, 'index']);

Auth::routes();

Route::get('/user/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('user.show');

Route::get('/home', [App\Http\Controllers\UserController::class, 'home'])->name('home');
Route::get('/settings', [App\Http\Controllers\UserController::class, 'settings'])->name('settings');
Route::get('/notifications', [App\Http\Controllers\UserController::class, 'notifications'])->name('notifications');
