<?php

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

Route::get('/', 'Home@index');

/**
* Shopify auth request
*/
Route::get('auth', [
    'as' => 'shopify-auth',
    'uses' => 'Auth@index'
]);

/**
* Shopify embedded dashboard
*/
Route::group([
    'prefix' => 'dashboard', 
    'as' => 'dashboard.',
    'middleware' => 'hmac'
], function() {

    // Dashboard index
    Route::get('/', [
        'as' => 'index',
        'uses' => 'Dashboard@index'
    ]);

});

