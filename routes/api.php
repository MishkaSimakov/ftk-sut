<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\DiscordController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\ArticlesRatingController;
use App\Http\Controllers\Statistics\ArticleStatisticsController;
use App\Http\Controllers\Statistics\CompareController;
use App\Http\Controllers\Statistics\EventStatisticsController;
use App\Http\Controllers\Statistics\RatingPointsStatisticsController;
use App\Http\Controllers\TravelsRatingController;
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

Route::get('rating/articles/show', [ArticlesRatingController::class, 'show'])->name('rating.articles.show');
Route::get('rating/travels/show', [TravelsRatingController::class, 'show'])->name('rating.travels.show');
Route::get('rating/show', [RatingController::class, 'show'])->name('rating.show');


Route::post('articles/images/store', [ArticleController::class, 'storeImage'])
    ->name('articles.images.store');


Route::prefix('statistics/')->name('stat.')->group(function () {
    Route::get('points/{user}', [RatingPointsStatisticsController::class, 'getShortPointsStatistics'])->name('points');
    Route::get('articles/{user}', [ArticleStatisticsController::class, 'getShortArticlesStatistics'])->name('articles');
    Route::get('events/{user}', [EventStatisticsController::class, 'getShortEventsStatistics'])->name('events');

    Route::get('compare/{first}/{second}', [CompareController::class, 'getCompareData'])->name('compare');
});

Route::prefix('discord/')->name('discord.')->group(function () {
    Route::get('invite', [DiscordController::class, 'invite'])->name('invite')->middleware('signed');
});
