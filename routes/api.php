<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Statistics\ArticleStatisticsController;
use App\Http\Controllers\Statistics\CompareController;
use App\Http\Controllers\Statistics\EventStatisticsController;
use App\Http\Controllers\Statistics\RatingPointsStatisticsController;

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

Route::prefix('articles')->name('articles.')->group(function () {
    Route::get('search', [ArticleController::class, 'search'])->name('search');
    Route::post('images/store', [ArticleController::class, 'storeImage'])->name('images.store');
});


Route::prefix('statistics/')->name('stat.')->group(function () {
    Route::get('points/{user}', [RatingPointsStatisticsController::class, 'getShortPointsStatistics'])->name('points');
    Route::get('articles/{user}', [ArticleStatisticsController::class, 'getShortArticlesStatistics'])->name('articles');
    Route::get('events/{user}', [EventStatisticsController::class, 'getShortEventsStatistics'])->name('events');

    Route::get('compare/{first}/{second}', [CompareController::class, 'getCompareData'])->name('compare');
});
