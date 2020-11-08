<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('news', \App\Http\Controllers\NewsController::class)->except('edit', 'create');

Route::get('/clubs', [\App\Http\Controllers\ClubController::class, 'index']);

Route::prefix('/rating')->name('rating.')->group(function() {
    Route::post('/precheck', [\App\Http\Controllers\RatingController::class, 'precheck'])->name('precheck')->middleware('admin');
});
