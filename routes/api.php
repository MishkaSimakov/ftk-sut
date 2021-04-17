<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\RatingController;

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

Route::resource('news', NewsController::class)->only('index');

Route::get('rating/show', [RatingController::class, 'show'])->name('rating.show');
Route::get('rating/categories', [RatingController::class, 'categories'])->name('rating.categories');

Route::get('article', [ArticleController::class, 'index'])->name('article.index');
Route::get('article/best', [ArticleController::class, 'best'])->name('article.best');
Route::get('article/{article}/points/toggle', [ArticleController::class, 'togglePoint'])
    ->name('article.points.toggle');

Route::get('article/tags', [ArticleController::class, 'tags'])->name('article.tags');
Route::get('article/search', [ArticleController::class, 'search'])->name('article.search');

//Route::get('/clubs', [\App\Http\Controllers\ClubController::class, 'index']);
