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

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/dashboard/device', 'HomeController@device')->name('dashboard-device');
Route::get('/dashboard/vehicle', 'HomeController@vehicle')->name('dashboard-vehicle');
Route::get('/dashboard/activity', 'HomeController@activity')->name('dashboard-activity');
Route::get('/dashboard/photo', 'HomeController@photo')->name('dashboard-photo');
Route::get('/profile', 'Auth\ProfileController@index')->name('profile_form');
Route::post('/profile', 'Auth\ProfileController@update')->name('profile_update');
Route::post('/device/add', 'DeviceController@add')->name('device-add');
Route::post('/device/enable/{id}', 'DeviceController@enable')->name('device-enable');
Route::post('/device/disable/{id}', 'DeviceController@disable')->name('device-disable');
Route::post('/device/disabling/{id}', 'DeviceController@disabling')->name('device-disabling');
Route::post('/device/dissociate/{id}', 'DeviceController@dissociate')->name('device-dissociate');
Route::post('/device/remove/{id}', 'DeviceController@remove')->name('device-remove');
Route::post('/device/associate-vehicle/{device_id}/{vehicle_id}', 'DeviceController@associateVehicle')->name('device-vehicle-association');
Route::post('/vehicle/add', 'VehicleController@add')->name('vehicle-add');
Route::post('/vehicle/edit/{id}', 'VehicleController@edit')->name('vehicle-edit');
Route::post('/vehicle/remove/{id}', 'VehicleController@remove')->name('vehicle-remove');