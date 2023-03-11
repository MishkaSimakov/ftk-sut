<?php

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

// info
Route::get('/', [\App\Http\Controllers\PageController::class, 'welcome'])->name('main');
Route::view('/about', 'about')->name('about');
Route::view('/help/register', 'help.register')->name('help.register');

// news
Route::resource('news', \App\Http\Controllers\NewsController::class);

// articles
Route::prefix('articles')->name('articles.')->group(function () {
    Route::get('tags', [\App\Http\Controllers\ArticleController::class, 'tags'])->name('tags.index');

    Route::get('search', \App\Http\Controllers\ArticleSearchController::class)->name('search');
    Route::get('unpublished', [\App\Http\Controllers\ArticleController::class, 'unpublished'])->name('unpublished');
    Route::get('unchecked', [\App\Http\Controllers\ArticleController::class, 'unchecked'])->name('unchecked');
    Route::get('drafts', [\App\Http\Controllers\ArticleController::class, 'drafts'])->name('drafts');
    Route::get('{article}/check', [\App\Http\Controllers\ArticleController::class, 'check'])->name('check');
});
Route::resource('articles', \App\Http\Controllers\ArticleController::class);

// events
Route::get('events/import', [\App\Http\Controllers\EventsController::class, 'import'])->name('events.import');
Route::post('events/import', [\App\Http\Controllers\EventsController::class, 'storeImported'])->name('events.store-imported');
Route::get('events/past', [\App\Http\Controllers\EventsController::class, 'past'])->name('events.past');
Route::get('events/{event}/users/edit', [\App\Http\Controllers\EventsController::class, 'editUsersList'])->name('events.users.edit');
Route::resource('events', \App\Http\Controllers\EventsController::class);

// rating
Route::get('rating/travels', [\App\Http\Controllers\TravelsRatingController::class, 'index'])->name('rating.travels.index');
Route::get('rating/articles', [\App\Http\Controllers\ArticlesRatingController::class, 'index'])->name('ratings.articles.index');

Route::resource('rating', \App\Http\Controllers\RatingController::class)
    ->only(['create', 'store']);


Route::get('rating/destroy', [\App\Http\Controllers\RatingController::class, 'showDestroyPage'])->name('rating.destroyPage');
Route::delete('rating/destroy', [\App\Http\Controllers\RatingController::class, 'destroy'])->name('rating.destroy');

Route::view('rating/export', 'ratings.export')->name('rating.show-export-form');
Route::post('rating/export', [\App\Http\Controllers\RatingController::class, 'export'])->name('rating.export');
Route::get('rating/{period?}', [\App\Http\Controllers\RatingController::class, 'index'])->name('rating.index');


// statistics
Route::prefix('statistics')->name('statistics.')->group(function () {
    Route::get('/points/{user}', [\App\Http\Controllers\Statistics\RatingPointsStatisticsController::class, 'show'])->name('points');
    Route::get('/compare/{user}', [\App\Http\Controllers\Statistics\CompareController::class, 'index'])->name('compare');
});


// admin
Route::get('/admin', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.index');

// users
Route::resource('users', \App\Http\Controllers\UserController::class);
Route::get('users/{user}/articles', [\App\Http\Controllers\UserController::class, 'articles'])->name('users.articles');
Route::get('users/{user}/achievements', [\App\Http\Controllers\AchievementController::class, 'index'])->name('users.achievements');

// auth routes
Auth::routes();

Route::get('/home', [App\Http\Controllers\UserController::class, 'home'])->name('home');
Route::get('/settings', [App\Http\Controllers\UserController::class, 'settings'])->name('settings');
