<?php

use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::prefix('1')->group(function () {

    Route::prefix('user')->group(function () {
        Route::post('register'          , 'AuthController@register');
        Route::post('login'             , 'AuthController@login');
        Route::get('logout'             , 'AuthController@logout');
        Route::put('update/{user}'      , 'AuthController@update');
    });


    Route::apiResource('books', 'BookController');
    Route::post('books/{book}/ratings', 'RatingController@store');

    Route::prefix('dashboard')->group(function () {
        Route::apiResource('promo', 'Dashboard\PromoController');
    });

});


