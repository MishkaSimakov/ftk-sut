<?php

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;

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

Route::post('/article/points', 'Api\ArticleController@points')->name('api.article.points');

Route::post('/admin/register_link', 'Api\AdminController@register_link')->name('api.admin.register_link');

Route::post('/schedule/add_people', 'Api\ScheduleController@add_people')->name('api.schedule.add_people');

Route::post('article/{article}/image', 'Api\ImageController@upload')->name('api.image.upload');
