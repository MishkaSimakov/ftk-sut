<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Event;




Route::get('/', 'MainController@index');

Route::get('/article/publish', 'ArticleController@notPublished')->name('article.notPublished')->middleware(['auth', 'admin']);
Route::put('/article/{article}/publish', 'ArticleController@publish')->name('article.publish')->middleware(['auth', 'admin']);
Route::delete('/article/{article}', 'ArticleController@destroy')->name('article.destroy')->middleware(['auth', 'admin']);

Route::resource('article', 'ArticleController')->middleware('auth')->only([
    'create', 'store', 'edit', 'update', 'destroy'
]);

Route::resource('article', 'ArticleController')->only([
    'index', 'show'
]);


Route::resource('rating', 'RatingController')->middleware(['auth', 'admin'])->only([
    'create', 'store'
]);

Route::resource('rating', 'RatingController')->only([
    'show', 'index'
]);




Route::get('/user/{user}', 'UserController@show')->name('user.show');
Route::get('/teacher/{teacher}', 'TeacherController@show')->name('teacher.show');

Route::resource('achievements', 'AchievementController')->only([
   'index'
]);


Route::get('/schedule', 'ScheduleController@index')->name('schedule.index');

Route::resource('schedule', 'ScheduleController')->middleware(['auth', 'admin'])->only([
	'create', 'store'
]);



Auth::routes();

Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');

Route::get('/admin', 'Admin\AdminController@index')->name('admin.index')->middleware(['auth', 'admin']);
