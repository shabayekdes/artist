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



Route::get('home', 'HomeController@index');
Route::get('categories', 'CategoryController@index');
Route::get('categories/{category}', 'CategoryController@show');
Route::get('portraits/{portrait}', 'PortraitController@show');
Route::resource('artists', 'ArtistController');


Route::middleware('auth:api')->group(function () {

    Route::resource('user-address', 'UserAddressController');
    Route::resource('checkout', 'CheckoutController');


});


Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');