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

Route::get('/rating/{rating}', 'Api\RatingController@show')->name('api.rating.show');


Route::get('/user/{user}/stats/points', 'Api\StatisticsController@points')->name('api.user.point_stats');
Route::get('/user/{user}/stats/categories', 'Api\StatisticsController@categories')->name('api.user.categories_stats');


Route::post('/schedule/register', 'Api\ScheduleController@register')->name('api.schedule.register');
Route::post('/schedule/unregister', 'Api\ScheduleController@unregister')->name('api.schedule.unregister');

Route::post('schedule/{schedule}/image', 'Api\ImageController@uploadScheduleImage')->name('api.schedule.upload_image');
Route::post('schedule/{schedule}/image/delete', 'Api\ImageController@deleteScheduleImage')->name('api.schedule.delete_image');

Route::post('article/{article}/image', 'Api\ImageController@uploadArticleImage')->name('api.article.upload_image');
Route::post('article/{article}/image/delete', 'Api\ImageController@deleteArticleImage')->name('api.article.delete_image');

Route::post('teacher/{teacher}/image', 'Api\ImageController@uploadTeacherImage')->name('api.teacher.upload_image');
Route::post('teacher/{teacher}/image/delete', 'Api\ImageController@deleteTeacherImage')->name('api.teacher.delete_image');


Route::post('/article/points', 'Api\ArticleController@points')->name('api.article.points');


Route::post('/admin/code', 'Api\AdminController@code')->name('api.admin.get_code');
