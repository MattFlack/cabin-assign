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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/camps', 'CampsController@index');
Route::get('/camps/create', 'CampsController@create');
Route::post('/camps', 'CampsController@store');
Route::get('/camps/{camp}', 'CampsController@show');
Route::patch('/camps/{camp}', 'CampsController@update');

Route::get('/camps/{camp}/campers/create', 'CampersController@create');
Route::post('/camps/{camp}/campers', 'CampersController@store');
