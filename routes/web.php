<?php

use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;

Route::get('/', 'MainController@index')->name('main');

Route::prefix('article')->name('article.')->group(function() {
    Route::get('/publish', 'ArticleController@notPublished')->name('notPublished')->middleware('admin');
    Route::put('/{article}/publish', 'ArticleController@publish')->name('publish')->middleware('admin');
    Route::delete('/{article}', 'ArticleController@destroy')->name('destroy')->middleware('admin');
    Route::get('/draft', 'ArticleController@draft')->name('draft');
});

Route::resource('article', 'ArticleController');




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


Route::post('/schedule/{schedule}/sign', 'Api\ScheduleController@sign')->name('schedule.sign');
Route::resource('schedule', 'ScheduleController');


Route::get('/vote/create', 'VoteController@create')->name('vote.create')->middleware('auth');
Route::post('/vote/store', 'VoteController@store')->name('vote.store')->middleware('auth');
Route::get('/vote/{vote}', 'VoteController@show')->name('vote.show');
Route::get('/vote/{vote}/widget', 'VoteController@widget');

Route::get('/webapi/vote/all', 'Api\VoteController@all');
Route::post('/webapi/vote/{vote}/vote', 'Api\VoteController@vote')->middleware('auth');

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


Route::get('/settings', 'Auth\AccountController@settings')->name('settings.show')->middleware(['auth', 'throttle:5,1']);
Route::post('/settings/image', 'Auth\AccountController@image')->name('settings.image')->middleware('auth');
Route::put('/settings', 'Auth\AccountController@update')->name('settings.update')->middleware('auth');

Route::prefix('chat')->middleware(['auth'])->namespace('Chat')->group(function () {
    Route::get('/', 'ChatController@index')->name('chat.index');
    Route::get('/{chat}', 'ChatController@show')->name('chat.show');

    Route::post('/', 'ChatController@store');
});



Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', 'NewsController@index')->name('index');
    Route::get('/create', 'NewsController@create')->name('create')->middleware(['auth', 'admin']);
    Route::post('/', 'NewsController@store')->name('store')->middleware(['auth', 'admin']);

    Route::get('/{news}/edit', 'NewsController@edit')->name('edit')->middleware(['auth', 'admin']);
    Route::put('/{news}', 'NewsController@update')->name('update')->middleware(['auth', 'admin']);
});


Route::group(['prefix' => 'webapi/chats', 'namespace' => 'Api'], function () {
    Route::get('/', 'ChatController@index');
    Route::post('/', 'ChatController@store')->middleware('throttle:5,1')->name('chat.store');

    Route::get('/{chat}', 'ChatController@show');
    Route::delete('/{chat}', 'ChatController@destroy');
    Route::post('/message/{message}/image', 'ChatMessageController@storeImage')->middleware('throttle:30,1');
    Route::post('/{chat}/message', 'ChatMessageController@store')->middleware('throttle:30,1');

    Route::post('/{chat}/users', 'ChatUserController@store')->middleware('throttle:10,1');
    Route::post('/{chat}/name', 'ChatController@changeName');
    Route::post('/{chat}/removeUser', 'ChatController@removeUser')->middleware('throttle:10,1');
    Route::post('/{chat}/read', 'ChatController@read');

    Route::put('/{chat}/message/{message}', 'ChatMessageController@update')->middleware('throttle:30,1');
});

Route::group(['prefix' => 'webapi/comments', 'namespace' => 'Api'], function () {
    Route::get('/{article}', 'CommentController@show');
    Route::post('/{article}', 'CommentController@store');
    Route::put('/{comment}', 'CommentController@update');
});

Route::group(['prefix' => 'webapi/articles', 'namespace' => 'Api'], function () {
    Route::get('/tags', 'ArticleController@tags');

    Route::get('/top/writers', 'ArticleController@writersTop');
    Route::get('/top/articles', 'ArticleController@articlesTop');
    Route::get('/top/comments', 'ArticleController@commentsTop');
});


Route::group(['prefix' => 'lab'], function () {
    Route::view('/', 'lab.main')->name('lab.main');
    Route::view('/live', 'lab.live')->name('lab.live');
    Route::view('/mandelbrot', 'lab.mandelbrot')->name('lab.mandelbrot');
    Route::view('/place', 'lab.place')->name('lab.place');
    Route::view('/shadow', 'lab.shadow')->name('lab.shadow');
    Route::view('/primes', 'lab.primes')->name('lab.primes');
    Route::view('/pendulum', 'lab.pendulum')->name('lab.pendulum');
    Route::view('/earth', 'lab.earth')->name('lab.earth');
});
