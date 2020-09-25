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
Route::post('page/contact-us', 'ContactUsController@store');

Route::get('page/{page}', 'PageController@show');

Route::resource('artists', 'ArtistController');


Route::middleware('auth:api')->group(function () {

    Route::resource('user-address', 'UserAddressController');
    Route::resource('checkout', 'CheckoutController');
    Route::get('/load-latest-messages', 'MessagesController@getLoadLatestMessages');
    Route::get('/fetch-old-messages', 'MessagesController@getOldMessages');
    Route::post('/messages', 'MessagesController@store');

    Route::get('/my-account', 'AccountController@index');
    Route::post('/my-account', 'AccountController@store');
    Route::get('/my-orders', 'OrderController@index');

    Route::post('portraits', 'PortraitController@store');


});


Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::post('check/otp', 'AuthController@otpCheck');
Route::post('forget-password', 'AuthController@forgetPassword');
