<?php

use App\Http\Controllers\Api\ArticleController;
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


Route::get('rating/show', [RatingController::class, 'show'])->name('rating.show');
Route::get('rating/categories', [RatingController::class, 'categories'])->name('rating.categories');

Route::get('article/search', [ArticleController::class, 'search'])->name('article.search');
Route::get('article/tags', [ArticleController::class, 'tags'])->name('article.tags');

Route::prefix('statistics/')->name('stat.')->group(function() {
    Route::get('points/{user}', [\App\Http\Controllers\Statistics\RatingPointsStatisticsController::class, 'getPointsByMonth'])->name('points');

});

//Route::get('/clubs', [\App\Http\Controllers\ClubController::class, 'index']);
