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
Route::delete('/camps/{camp}', 'CampsController@destroy');

//Route::get('/camps/{camp}/campers/create', 'CampersController@create');
Route::post('/camps/{camp}/campers', 'CampersController@store');
Route::get('/camps/{camp}/campers', 'CampersController@index');
Route::get('/camps/{camp}/campers/{camper}', 'CampersController@show');
Route::delete('/camps/{camp}/campers/{camper}', 'CampersController@destroy');

Route::post('/camps/{camp}/campers/{camper}', 'FriendshipsController@store');
Route::delete('/camps/{camp}/campers/{camper}/friendships/{friendship}', 'FriendshipsController@destroy');

Route::post('/camps/{camp}/cabins/', 'CabinsController@store');
Route::get('/camps/{camp}/cabins/', 'CabinsController@index');