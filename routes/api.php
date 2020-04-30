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

# Auth Users
Route::post('login', 'Api\\UserController@login');
Route::post('register', 'Api\\UserController@store');

Route::middleware('check_token')->group(function() {
    Route::get('/events_recommended', 'Api\\EventController@eventsRecommended');
    Route::get('/events_filter', 'Api\\EventController@eventsFilter');
});
