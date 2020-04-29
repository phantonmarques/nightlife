<?php

use Illuminate\Support\Facades\Route;

/**
 *  Página principal para todos
 * TODO: Institucional
 */
Route::get('/', 'SiteInstitucional\SiteInstController@index')->name('home');

#######################################################################################################################################

Route::group(['middleware' => ['auth'], 'prefix' => '/control/'], function () {
    /**
     *  Página de admin, com níveis de privilégio.
     * TODO: Admin
     */

    # Index
    Route::get('/', 'Admin\\AdminController@index')->name('admin.page');

    # Establishment Routes Access
    Route::get('dashboard', 'Admin\\AdminController@dashboard')->name('admin.dashboard');


    # Category
    Route::get('category/{category}/destroy', 'Admin\\CategoryController@destroy')->name('category.destroy')->middleware('auth');
    Route::resource('category', 'Admin\\CategoryController')->except(['destroy'])->middleware('auth');

    # Musical Rhythm
    Route::get('rhythm/{rhythm}/destroy', 'Admin\\RhythmController@destroy')->name('rhythm.destroy')->middleware('auth');
    Route::resource('rhythm', 'Admin\\RhythmController')->except(['destroy'])->middleware('auth');

    # Establishment
    Route::get('establishment/{establishment}/destroy', 'Admin\\EstablishmentController@destroy')->name('establishment.destroy')->middleware('auth');
    Route::resource('establishment', 'Admin\\EstablishmentController')->except(['destroy'])->middleware('auth');

    # Establishment Address
    Route::get('establishmentAddress/{establishmentAddress}/destroy', 'Admin\\EstablishmentAddressController@destroy')->name('establishmentAddress.destroy')->middleware('auth');
    Route::get('establishmentAddress/prepareIndex', 'Admin\\EstablishmentAddressController@prepareIndex')->name('establishmentAddress.prepareIndex')->middleware('auth');
    Route::resource('establishmentAddress', 'Admin\\EstablishmentAddressController')->except(['destroy'])->middleware('auth');

    # User
    Route::get('user/{user}/destroy', 'Admin\\UserController@destroy')->name('user.destroy')->middleware('auth');
    Route::resource('user', 'Admin\\UserController')->except(['destroy'])->middleware('auth');

    # Role
    Route::get('role/{role}/destroy', 'Admin\\RoleController@destroy')->name('role.destroy')->middleware('auth');
    Route::resource('role', 'Admin\\RoleController')->except(['destroy'])->middleware('auth');

    # Permission
    Route::get('permission/{permission}/destroy', 'Admin\\PermissionController@destroy')->name('permission.destroy')->middleware('auth');
    Route::delete('massDestroy', 'Admin\PermissionController@massDestroy')->name('permission.massDestroy')->middleware('auth');;
    Route::resource('permission', 'Admin\\PermissionController')->except(['destroy'])->middleware('auth');

    # Event
    Route::get('event/{event}/destroy', 'Admin\\EventController@destroy')->name('event.destroy')->middleware('auth');
    Route::get('event/prepareIndex', 'Admin\\EventController@prepareIndex')->name('event.prepareIndex')->middleware('auth');
    Route::resource('event', 'Admin\\EventController')->except(['destroy'])->middleware('auth');
});
#######################################################################################################################################


/**
 * TODO: Funções Padrões do Sistema
 */

# Busca Cidades
Route::get('citys/{state_id}', 'SiteInstitucional\SiteInstController@searchCitys')->name('searchCitys');

# Busca ID Estado
Route::get('state/{state_id}', 'SiteInstitucional\SiteInstController@searchState')->name('searchState');

# Rotas para registrar usuários comuns
Route::get('register', ['uses' => 'Auth\RegisterController@showRegistrationForm'])->name('register.page');
Route::post('register', ['uses' => 'Auth\RegisterController@register'])->name('register.action');

# Rotas de autenticação para todos usuários
Route::get('login', ['as' => 'login', 'uses' => 'SiteInstitucional\SiteInstController@login']);
Route::post('login', ['as' => '', 'uses' => 'Auth\LoginController@login']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

# Rotas para resetas senha para todos usuários
Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/reset', ['as' => 'password.update', 'uses' => 'Auth\ResetPasswordController@reset']);
Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
