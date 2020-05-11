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

# Routes: Auth Users and Register
Route::post('login', 'Api\\UserController@login');
Route::post('register', 'Api\\UserController@store');

Route::middleware('check_token')->group(function() {
    # Routes: Event
    Route::get('/event/{id}', 'Api\\EventController@event');
    Route::get('/events_recommended', 'Api\\EventController@eventsRecommended');
    Route::get('/events_filter', 'Api\\EventController@eventsFilter');
    Route::post('/events_search', 'Api\\EventController@eventsSearch');

    # Routes: Establishment
    Route::get('/establishment/{id}', 'Api\\EstablishmentController@establishment');
    Route::get('/establishment_details/{id}', 'Api\\EstablishmentController@establishmentDetails');
    Route::get('/establishment_ratings/{id}', 'Api\\EstablishmentController@establishmentRatings');
    Route::get('/establishment_comments/{id}', 'Api\\EstablishmentController@establishmentComments');

    # Routes: User
    Route::get('/user', 'Api\\UserController@info');
    Route::post('/user_rating', 'Api\\UserController@storeRating');
    Route::post('/user_comment', 'Api\\UserController@storeComment');
});
