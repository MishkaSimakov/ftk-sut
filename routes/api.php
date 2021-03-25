<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('news', \App\Http\Controllers\Api\NewsController::class)->only('index');

Route::get('rating/show/{period?}', [\App\Http\Controllers\Api\RatingController::class, 'show'])
    ->name('rating.show')
    ->where('period', '[0-9]{4}\.[0-9]{2}\-[0-9]{4}\.[0-9]{2}');  // regex for 'YYYY.MM-YYYY.MM' query
Route::get('rating/categories', [\App\Http\Controllers\Api\RatingController::class, 'categories'])->name('rating.categories');

Route::get('articles', [\App\Http\Controllers\Api\ArticleController::class, 'index'])->name('article.index');
Route::get('article/tags', [\App\Http\Controllers\Api\ArticleController::class, 'tags'])->name('article.tags');
Route::get('article/search', [\App\Http\Controllers\Api\ArticleController::class, 'search'])->name('article.search');

//Route::get('/clubs', [\App\Http\Controllers\ClubController::class, 'index']);
