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

Route::resource('experiments', 'Api\ExperimentController')
    ->only(['index', 'store', 'show']);

Route::group(['prefix' => 'experiments'], function () {
    Route::post('/assign-smart-view', 'Api\ExperimentController@assignSmartView');
});

Route::group(['prefix' => 'smart-views'], function () {
    Route::get('/', 'Api\SmartViewController@index');
});
