<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/rating/chart', 'Api\RatingController@chart')->name('api.rating.chart');
Route::get('/home/statistic', 'Api\RatingController@userStatistic')->name('api.home.statistic');

Route::post('/article/points', 'Api\ArticleController@points')->name('api.article.points');

Route::post('/admin/register_link', 'Api\AdminController@register_link')->name('api.admin.register_link');