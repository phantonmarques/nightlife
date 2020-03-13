<?php

use Illuminate\Support\Facades\Route;

/**
*  Página principal para todos
* TODO: Institucional
*/
Route::get('/', 'SiteInstitucional\SiteInstController@index')->name('home');


#######################################################################################################################################


/**
*  Página do usuário comum e todos.
* TODO: Site
*/
Route::group(['middleware' => ['auth'], 'prefix' => '/site'], function () {
    Route::get('/', 'Site\SiteController@index');
});

#######################################################################################################################################

/**
*  Página de admin, com níveis de privilégio.
* TODO: Admin
*/
Route::group(['middleware' => ['auth'], 'prefix' => '/control'], function () {
    Route::get('/', 'ControlAdmin\AdminController@index')->name('home.page.admin');

    # Rotas para administrador (sócios)
    Route::get('criar-estabelecimento', 'ControlAdmin\AdminController@criarEstabelecimento');
    Route::post('inserir-estabelecimento', 'ControlAdmin\AdminController@inserirEstabelecimento')->name('inserirEstabelecimento');
    Route::get('lista-estabelecimento', 'ControlAdmin\AdminController@listarEstabelecimentos')->name('listaEstabelecimentos');
});

# Establishment
    Route::get('establishment/{establishment}/destroy', 'Admin\\EstablishmentController@destroy')->name('establishment.destroy')->middleware('auth');
//    Route::get('establishment/{establishment}', 'Admin\\EstablishmentController@index')->name('establishment.index')->middleware('auth');
    Route::resource('establishment', 'Admin\\EstablishmentController')->except(['destroy'])->middleware('auth');
//    Route::resource('establishment', 'Admin\\EstablishmentController')->only([ 'index', 'edit', 'update', 'create', 'store', 'show' ])->middleware('auth');

# Establishment Address
    Route::get('establishmentAddress/{establishmentAddress}/destroy', 'Admin\\EstablishmentAddressController@destroy')->name('establishmentAddress.destroy')->middleware('auth');
    Route::get('establishmentAddress/prepareIndex', 'Admin\\EstablishmentAddressController@prepareIndex')->name('establishmentAddress.prepareIndex')->middleware('auth');
    Route::resource('establishmentAddress', 'Admin\\EstablishmentAddressController')->only([ 'index', 'edit', 'update', 'create', 'store', 'show' ])->middleware('auth');

#######################################################################################################################################


/**
* TODO: Funções Padrões do Sistema
*/

# Busca Cidades
Route::get('citys/{state_id}', 'SiteInstitucional\SiteInstController@buscarCidades')->name('buscarCidades');

# Rotas para registrar usuários comuns
Route::get('register', ['uses' => 'Auth\RegisterController@showRegistrationForm'])->name('register.page');
Route::post('register', ['uses' => 'Auth\RegisterController@register'])->name('register.action');

# Rotas de autenticação para todos usuários
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => '', 'uses' => 'Auth\LoginController@login']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

# Rotas para resetas senha para todos usuários
Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/reset', ['as' => 'password.update', 'uses' => 'Auth\ResetPasswordController@reset']);
Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);

//# Rotas para registrar usuário
//    Route::get('register', ['uses' => 'Auth\RegisterController@showRegistrationForm'])->name('register.page');
//    Route::post('register', ['uses' => 'Auth\RegisterController@register'])->name('register.action');

