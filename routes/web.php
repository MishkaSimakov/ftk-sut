<?php

use \Illuminate\Support\Facades\Route;
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


Route::get('/settings', 'Auth\AccountController@settings')->name('settings.show')->middleware('auth');
Route::put('/settings', 'Auth\AccountController@update')->name('settings.update')->middleware('auth');

Route::view('/register/help', 'auth.help')->name('register.help');

Route::get('/markup/{view}', 'MarkupController@show')->name('markup.show');

Route::prefix('chat')->middleware(['auth'])->namespace('Chat')->group(function () {
    Route::get('/', 'ChatController@index')->name('chat.index');
    Route::get('/{chat}', 'ChatController@show')->name('chat.show');

    Route::post('/', 'ChatController@store');
});



Route::get('/news', 'NewsController@index')->name('news.index');
Route::get('/news/create', 'NewsController@create')->name('news.create');
Route::post('/news', 'NewsController@store')->name('news.store');



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
});

Route::group(['prefix' => 'webapi/comments', 'namespace' => 'Api'], function () {
    Route::get('/{article}', 'CommentController@show');
    Route::post('/{article}', 'CommentController@store');
});

Route::group(['prefix' => 'webapi/articles', 'namespace' => 'Api'], function () {
    Route::get('/tags', 'ArticleController@tags');

    Route::get('/top/writers', 'ArticleController@writersTop');
    Route::get('/top/articles', 'ArticleController@articlesTop');
});
