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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::middleware('auth:api')->get('/camps/{camp}/campers', function (Request $request) {
//    return $request->user();
//});


Route::get('/camps/{camp}/campers', 'CampersController@index');

//Route::group(['middleware' => 'auth:api'], function() {
//    Route::get('/camp/{camp}', 'CampersController@index');
//});
