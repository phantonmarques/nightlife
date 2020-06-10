<?php

use Illuminate\Support\Facades\Route;

/**
 *  Page main for all
 * TODO: Institutional
 */
Route::get('/', 'SiteInstitucional\SiteInstController@index')->name('home');

#######################################################################################################################################

Route::group(['middleware' => 'auth', 'prefix' => '/control/'], function () {
    /**
     *  Página de admin, com níveis de privilégio.
     * TODO: Admin
     */

    # Index
        Route::get('/', 'Admin\\AdminController@index')->name('admin.page');

    # Establishment Routes Access
        # DASHBOARD
            Route::get('dashboard', 'Admin\\AdminController@dashboard')->name('admin.dashboard');

        # EVENT
            Route::get('event/{event}/destroy', 'Admin\\EventController@destroy')->name('event.destroy');
            Route::resource('event', 'Admin\\EventController')->except(['destroy']);

        # SETTINGS
            Route::get('details', 'Admin\\AdminController@details')->name('admin.details');
            Route::get('pictures', 'Admin\\AdminController@changePictures')->name('admin.pictures');
            Route::post('updatePictures', 'Admin\\AdminController@updatePictures')->name('admin.updatePictures');
            Route::delete('removePictures', 'Admin\\AdminController@removePicture')->name('admin.removePicture');
            Route::get('settings', 'Admin\\AdminController@settings')->name('admin.settings');
            Route::post('updateSettings', 'Admin\\AdminController@updateSettings')->name('admin.updateSettings');

        # REPORTS
            Route::get('reports', 'Admin\\AdminController@reports')->name('admin.reports');
            Route::post('generateReports', 'Admin\\AdminController@generateReport')->name('admin.generateReport');

    # Admin|Employee Access *SPECIAL*
        Route::post('establishmentConnect', 'Admin\\AdminController@establishmentConnect')->name('admin.establishment');

    # Access Log User
        Route::resource('logs', 'Admin\\UserAccessController')->except(['destroy']);

    # Category
        Route::get('category/{category}/destroy', 'Admin\\CategoryController@destroy')->name('category.destroy');
        Route::delete('category/massDestroy', 'Admin\\CategoryController@massDestroy')->name('category.massDestroy');
        Route::resource('category', 'Admin\\CategoryController')->except(['destroy']);

    # Called
        Route::resource('called', 'Admin\\CalledController')->except(['destroy']);

    # Musical Rhythm
        Route::get('rhythm/{rhythm}/destroy', 'Admin\\RhythmController@destroy')->name('rhythm.destroy');
        Route::delete('rhythm/massDestroy', 'Admin\\RhythmController@massDestroy')->name('rhythm.massDestroy');
        Route::resource('rhythm', 'Admin\\RhythmController')->except(['destroy']);

    # Establishment
        Route::get('establishment/{establishment}/destroy', 'Admin\\EstablishmentController@destroy')->name('establishment.destroy');
        Route::delete('establishment/massDestroy', 'Admin\\EstablishmentController@massDestroy')->name('establishment.massDestroy');
        Route::resource('establishment', 'Admin\\EstablishmentController')->except(['destroy']);

    # Establishment Address
        Route::get('establishmentAddress/{establishmentAddress}/destroy', 'Admin\\EstablishmentAddressController@destroy')->name('establishmentAddress.destroy');
        Route::delete('establishmentAddress/massDestroy', 'Admin\\EstablishmentAddressController@massDestroy')->name('establishmentAddress.massDestroy');
        Route::resource('establishmentAddress', 'Admin\\EstablishmentAddressController')->except(['destroy']);

    # User
        Route::get('user/{user}/destroy', 'Admin\\UserController@destroy')->name('user.destroy');
        Route::delete('user/massDestroy', 'Admin\\UserController@massDestroy')->name('user.massDestroy');
        Route::resource('user', 'Admin\\UserController')->except(['destroy']);

    # Role
        Route::get('role/{role}/destroy', 'Admin\\RoleController@destroy')->name('role.destroy');
        Route::delete('role/massDestroy', 'Admin\\RoleController@massDestroy')->name('role.massDestroy');
        Route::resource('role', 'Admin\\RoleController')->except(['destroy']);

    # Permission
        Route::get('permission/{permission}/destroy', 'Admin\\PermissionController@destroy')->name('permission.destroy');
        Route::delete('permission/massDestroy', 'Admin\\PermissionController@massDestroy')->name('permission.massDestroy');
        Route::resource('permission', 'Admin\\PermissionController')->except(['destroy']);

    # News
        Route::get('news/{news}/destroy', 'Admin\\NewsController@destroy')->name('news.destroy');
        Route::resource('news', 'Admin\\NewsController')->except(['destroy']);

    /**
     * TODO: Settings all users that belongs
     */

    # USER LOGGED

        # View change new password
            Route::get('changePassword', 'Admin\\AdminController@editPassword')->name('settings.changePassword');

        # Reset new password
            Route::post('reset', 'Admin\\AdminController@resetPassword')->name('settings.reset');

        # Route valid password recent
            Route::get('valid/{password}', 'Admin\\AdminController@validPasswordRecent')->name('settings.valid');

        # View change new picture and remove picture
            Route::get('changePicture', 'Admin\\AdminController@changeProfilePicture')->name('settings.changePicture');
            Route::delete('removePicture', 'Admin\\AdminController@removeProfilePicture')->name('settings.removePicture');

        # New/Alter profile picture
            Route::post('picture', 'Admin\\AdminController@updateProfilePicture')->name('settings.picture');

    /**
     * TODO: Utilities functions
     */

    # Search citys of certain state
        Route::get('citys/{state_id}', 'Admin\\AdminController@searchCitys')->name('searchCitys');

    # Search state selected
        Route::get('state/{state_id}', 'Admin\\AdminController@searchState')->name('searchState');
});
#######################################################################################################################################


/**
 * TODO: Funções Padrões do Sistema
 */

# Rota de confirmação de conta usuário comum
    Route::get('/confirm/{token}', 'SiteInstitucional\SiteInstController@confirmEmail')->name('confirm.account');

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
