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

Route::get('/', function () {
    return view('welcome');
});


Route::view('/html/main', 'html.main');
Route::view('/html/news', 'html.news');


Route::get('/article', 'ArticleController@index')->name('article.index');

Route::get('/article/publish', 'ArticleController@notPublished')->name('article.notPublished')->middleware('admin');
Route::put('/article/{article}/publish', 'ArticleController@publish')->name('article.publish')->middleware('admin');
Route::delete('/article/{article}', 'ArticleController@destroy')->name('article.destroy')->middleware('admin');

Route::resource('article', 'ArticleController')->middleware('auth')->only([
    'create', 'store', 'edit', 'update', 'destroy'
]);


Route::resource('rating', 'RatingController')->middleware(['auth','admin'])->only([
    'create', 'store'
]);

Route::resource('rating', 'RatingController')->only([
    'show', 'index'
]);




Route::resource('user', 'UserController')->only([
    'index', 'show'
]);

Route::resource('achievements', 'AchievementController')->only([
   'index'
]);


Route::get('/schedule', 'ScheduleController@index')->name('schedule.index');

Route::resource('schedule', 'ScheduleController')->middleware('admin')->only([
	'create', 'store'
]);



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'Admin\AdminController@index')->name('admin.index')->middleware('admin');
