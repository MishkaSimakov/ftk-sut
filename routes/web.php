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

# info
Route::get('/', [\App\Http\Controllers\PageController::class, 'welcome'])->name('main');
Route::view('/about', 'about')->name('about');
Route::view('/help/register', 'help.register')->name('help.register');

# reviews
Route::resource('reviews', \App\Http\Controllers\ReviewController::class)->only(['index', 'store', 'destroy']);

# news
Route::resource('news', \App\Http\Controllers\NewsController::class);

# articles
Route::get('articles/unpublished', [\App\Http\Controllers\ArticleController::class, 'unpublished'])->name('articles.unpublished');
Route::get('articles/unchecked', [\App\Http\Controllers\ArticleController::class, 'unchecked'])->name('articles.unchecked');
Route::get('articles/{article}/check', [\App\Http\Controllers\ArticleController::class, 'check'])->name('articles.check');
Route::resource('articles', \App\Http\Controllers\ArticleController::class);

# events
Route::permanentRedirect('/schedule ', '/events');

Route::get('events/past', [\App\Http\Controllers\EventsController::class, 'past'])->name('events.past');
Route::get('events/{event}/users/edit', [\App\Http\Controllers\EventsController::class, 'editUsersList'])->name('events.users.edit');
Route::resource('events', \App\Http\Controllers\EventsController::class);

# rating
Route::resource('rating', \App\Http\Controllers\RatingController::class)
    ->only(['create', 'store']);


Route::get('rating/destroy', [\App\Http\Controllers\RatingController::class, 'showDestroyPage'])->name('rating.destroyPage');
Route::delete('rating/destroy', [\App\Http\Controllers\RatingController::class, 'destroy'])->name('rating.destroy');

Route::get('rating/export/{period}', [\App\Http\Controllers\RatingController::class, 'export'])->name('rating.export');
Route::get('rating/{period?}', [\App\Http\Controllers\RatingController::class, 'index'])->name('rating.index');

Route::prefix('statistics')->name('statistics.')->group(function () {
    Route::get('/points/{user}', [\App\Http\Controllers\Statistics\RatingPointsStatisticsController::class, 'show'])->name('points');
    Route::get('/compare/{user}', [\App\Http\Controllers\Statistics\CompareController::class, 'index'])->name('compare');
});

# admin
Route::get('/admin', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.index');

# users
Route::resource('users', \App\Http\Controllers\UserController::class);
Route::get('users/{user}/articles', [\App\Http\Controllers\UserController::class, 'articles'])->name('users.articles');
Route::get('users/{user}/achievements', [\App\Http\Controllers\AchievementController::class, 'index'])->name('users.achievements');

# auth routes
Auth::routes();

Route::get('/home', [App\Http\Controllers\UserController::class, 'home'])->name('home');
Route::get('/settings', [App\Http\Controllers\UserController::class, 'settings'])->name('settings');


Route::get('/mailable', function () {
    return new App\Mail\RatingNotification(now());
});
