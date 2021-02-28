<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::view('/', 'welcome')->name('main');

# news
Route::resource('news', \App\Http\Controllers\NewsController::class);

# rating
Route::resource('ratings', \App\Http\Controllers\RatingController::class)->except('edit', 'update', 'show');

# other
Route::get('/clubs', [\App\Http\Controllers\ClubController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
