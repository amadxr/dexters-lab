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

Route::get('/', 'ExperimentController@index')->name('home');
Route::get('create', 'ExperimentController@create')->name('create');
Route::get('show/{experiment}', 'ExperimentController@show');
