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
use \Illuminate\Support\Facades\Auth;




Route::get('/', 'MainController@index')->name('main');

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
Route::post('/teacher', 'TeacherController@store')->name('teacher.store')->middleware(['auth', 'admin']);

Route::resource('achievements', 'AchievementController')->only([
   'index'
]);


Route::get('/schedule', 'ScheduleController@index')->name('schedule.index');
Route::get('/schedule/archive', 'ScheduleController@archive')->name('schedule.archive');

Route::resource('schedule', 'ScheduleController')->middleware(['auth', 'admin'])->only([
	'create', 'store', 'destroy', 'edit', 'update'
]);



Auth::routes([
    'register' => true,
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');

Route::prefix('admin')->middleware(['auth', 'admin'])->namespace('Admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin.index');

    Route::get('teacher/{teacher}/edit', 'AdminController@teacherEdit')->name('admin.teacher.edit');

    Route::put('student/{student}/settings', 'AdminController@studentSettings')->name('admin.student.settings');
    Route::put('teacher/{teacher}/settings', 'AdminController@teacherSettings')->name('admin.teacher.settings');
});


Route::get('/settings', 'Auth\AccountController@settings')->name('settings.show');
Route::put('/settings', 'Auth\AccountController@update')->name('settings.update');

Route::view('/register/help', 'auth.help')->name('register.help');

Route::get('/markup/{view}', 'MarkupController@show')->name('markup.show');
