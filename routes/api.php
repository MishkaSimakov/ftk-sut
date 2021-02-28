<?php

use Illuminate\Support\Facades\Route;

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

Route::resource('news', \App\Http\Controllers\Api\NewsController::class)->only('index');

//Route::resource('ratings', \App\Http\Controllers\RatingController::class)->except('edit', 'create', 'show');
Route::get('ratings/show', [\App\Http\Controllers\Api\RatingController::class, 'show'])->name('ratings.show');
//
//Route::get('/clubs', [\App\Http\Controllers\ClubController::class, 'index']);
