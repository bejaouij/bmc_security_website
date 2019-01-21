<?php

namespace App\Http\Controllers;

use App\Get;
use App\Code;
use App\Status;
use App\Device;
use App\VehicleStatus;
use Illuminate\Http\Request;

class ApiDeviceController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($device_serial)
    {
        if(!($device = Device::where('device_serial_number', $device_serial)->first()))
            return ['status' => 'ERROR', 'response' => 'Device with serial "' . $device_serial . '" does not exist.'];

        $deviceLastStatus = Get::where('device_id', $device->device_id)
            ->orderBy('date_date', 'DESC')
            ->first();

        return [
            'status_code' => Status::find($deviceLastStatus->status_code)->status_code,
            'vehicle_status' => !is_null($device->vehicle) ? $device->vehicle->lastStatus()->status->status_code : null,
            'in_disabling' => !is_null(Code::where('device_id', $device->device_id)->where('code_is_used', false)->first())
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($device_serial, $new_status)
    {
        if(!($device = Device::where('device_serial_number', $device_serial)->first()))
            return ['status' => 'ERROR', 'response' => 'Device with serial "' . $device_serial . '" does not exist.'];

        if(!in_array($new_status, ['0', '1', '2']))
            return ['status' => 'ERROR', 'response' => 'New status must be between 0 and 2.'];

        $get = new Get();
        $get->status_code = $new_status;
        $get->device_id = $device->device_id;
        $get->save();

        return ['status' => 'OK', 'response' => 'Status modified with success.'];
    }

    public function editVehicle($device_serial, $new_status)
    {
        if(!($device = Device::where('device_serial_number', $device_serial)->first()))
            return ['status' => 'ERROR', 'response' => 'Device with serial "' . $device_serial . '" does not exist.'];

        if(!$device->vehicle)
            return ['status' => 'ERROR', 'response' => 'Specified device must have an associated vehicle.'];

        if(!in_array($new_status, ['3', '4', '5']))
            return ['status' => 'ERROR', 'response' => 'New status must be between 3 and 5.'];

        $vehicleStatus = new VehicleStatus();
        $vehicleStatus->vehicle_id = $device->vehicle->vehicle_id;
        $vehicleStatus->status_code = $new_status;
        $vehicleStatus->save();

        return ['status' => 'OK', 'response' => 'Status modified with success.'];
    }
}
