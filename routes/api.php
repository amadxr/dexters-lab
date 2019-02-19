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

Route::group(['prefix' => 'experiments'], function () {
    Route::get('/', 'Api\ExperimentController@index');
    Route::post('/', 'Api\ExperimentController@store');
    Route::post('/assign-smart-view', 'Api\ExperimentController@assignSmartView');
});

Route::group(['prefix' => 'smart-views'], function () {
    Route::get('/', 'Api\SmartViewController@index');
});

Route::group(['prefix' => 'tags'], function () {
    Route::get('/', 'Api\TagController@index');
});
