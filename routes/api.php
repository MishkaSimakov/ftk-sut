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

Route::post('/schedule/add_student', 'Api\ScheduleController@add_student')->name('api.schedule.add_student');

Route::post('article/{article}/image', 'Api\ImageController@uploadArticleImage')->name('api.article.upload_image');


Route::post('/admin/code', 'Api\AdminController@code')->name('api.admin.get_code');
