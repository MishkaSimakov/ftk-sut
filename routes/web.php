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
Route::resource('article', \App\Http\Controllers\ArticleController::class);


# events

# rating
Route::get('rating/{date?}', [\App\Http\Controllers\RatingController::class, 'index'])
    ->name('rating.index')
    ->where('date', '[0-9]{4}\.[0-9]{2}\-[0-9]{4}\.[0-9]{2}');  // regex for 'YYYY.MM-YYYY.MM' query
Route::resource('rating', \App\Http\Controllers\RatingController::class)
    ->except('index', 'edit', 'update', 'show');

# other
Route::get('/clubs', [\App\Http\Controllers\ClubController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
