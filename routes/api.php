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

# Routes: Auth Users, Register, Auth Painel and Recover Password
Route::post('login', 'Api\\UserController@login');
Route::post('loginSocialNetworks', 'Api\\UserController@loginSocialNetworks');
Route::post('register', 'Api\\UserController@store');
Route::get('auth_painel/{token}', 'Api\\UserController@authAdmin');
Route::post('recover_password', 'Api\\UserController@recoverPassword');

Route::middleware('check_token')->group(function() {
    # Routes: Event
    Route::get('event/{id}', 'Api\\EventController@event');
    Route::get('events_recommended', 'Api\\EventController@eventsRecommended');
    Route::get('events_filter', 'Api\\EventController@eventsFilter');
    Route::post('events_search', 'Api\\EventController@eventsSearch');

    # Routes: Establishment
    Route::get('establishment/{id}', 'Api\\EstablishmentController@establishment');
    Route::get('establishment_details/{id}', 'Api\\EstablishmentController@establishmentDetails');
    Route::get('establishment_ratings/{id}', 'Api\\EstablishmentController@establishmentRatings');
    Route::get('establishment_comments/{id}', 'Api\\EstablishmentController@establishmentComments');

    # Routes: User
    Route::get('user', 'Api\\UserController@info');
    Route::post('user_rating', 'Api\\UserController@storeRating');
    Route::post('user_comment', 'Api\\UserController@storeComment');
    Route::post('user_picture', 'Api\\UserController@updateImg');
    Route::post('user_update', 'Api\\UserController@update');
    Route::get('user_establishment_follow/{id}', 'Api\\UserController@establishmentFollow');
    Route::get('user_establishment_nofollow/{id}', 'Api\\UserController@establishmentUnfollow');
    Route::get('user_event_follow/{id}', 'Api\\UserController@eventFollow');
    Route::get('user_event_nofollow/{id}', 'Api\\UserController@eventUnfollow');
    Route::get('states', 'Api\\UserController@searchStates');
    Route::get('citys/{state_id}', 'Api\\UserController@searchCitys');

});
