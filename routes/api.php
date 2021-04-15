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

Route::get('rating/show', [\App\Http\Controllers\Api\RatingController::class, 'show'])->name('rating.show');
Route::get('rating/categories', [\App\Http\Controllers\Api\RatingController::class, 'categories'])->name('rating.categories');

Route::get('article', [\App\Http\Controllers\Api\ArticleController::class, 'index'])->name('article.index');
Route::get('article/best', [\App\Http\Controllers\Api\ArticleController::class, 'best'])->name('article.best');
Route::get('article/{article}/points/toggle', [\App\Http\Controllers\Api\ArticleController::class, 'togglePoint'])->name('article.points.toggle');

Route::get('article/tags', [\App\Http\Controllers\Api\ArticleController::class, 'tags'])->name('article.tags');
Route::get('article/search', [\App\Http\Controllers\Api\ArticleController::class, 'search'])->name('article.search');

//Route::get('/clubs', [\App\Http\Controllers\ClubController::class, 'index']);
