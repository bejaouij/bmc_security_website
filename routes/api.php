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

Route::get('/positions/{device_serial}', 'PositionController@index');
Route::get('/device/{device_serial}', 'ApiDeviceController@show');
Route::get('/device/user/{device_serial}', 'ApiDeviceController@showUser');
Route::get('/device/vehicle/{device_serial}', 'ApiDeviceController@showVehicle');
Route::post('/device/{device_serial}/{new_status}', 'ApiDeviceController@edit');
Route::post('/device/vehicle/{device_serial}/{new_status}', 'ApiDeviceController@editVehicle');
Route::post('/device/code/{device_serial}/{code}', 'ApiDeviceController@createCode');
Route::post('/position/{device_serial}/{x}/{y}', 'PositionController@store');