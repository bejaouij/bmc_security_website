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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/positions', 'PositionController@index');
Route::get('/device/{device_serial}', 'ApiDeviceController@show');
Route::post('/position/{device_serial}/{x}/{y}', 'PositionController@store');