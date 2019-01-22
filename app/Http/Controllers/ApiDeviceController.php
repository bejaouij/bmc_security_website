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
            'device_name' => $device->device_name,
            'vehicle_name' => !is_null($device->vehicle) ? $device->vehicle->vehicle_name : 'Non défini.',
            'status_code' => Status::find($deviceLastStatus->status_code)->status_code,
            'vehicle_status' => !is_null($device->vehicle) ? $device->vehicle->lastStatus()->status->status_code : null,
            'in_disabling' => !is_null(Code::where('device_id', $device->device_id)->where('code_is_used', false)->first())
        ];
    }

    public function showUser($device_serial)
    {
        if(!($device = Device::where('device_serial_number', $device_serial)->first()))
            return ['status' => 'ERROR', 'response' => 'Device with serial "' . $device_serial . '" does not exist.'];

        if(!$device->user)
            return ['status' => 'ERROR', 'response' => 'Device with serial "' . $device_serial . '" has no user associated.'];

        return [
            'user_firstname' => $device->user->user_firstname,
            'user_lastname' => $device->user->user_lastname,
            'user_phone_number' => $device->user->user_phone_number,
            'user_email' => $device->user->email,
            'user_address_street_number' => !is_null($device->user->address) ? $device->user->address->address_street_number : 'Non renseigné',
            'user_address_street' => !is_null($device->user->address) ? $device->user->address->address_street : 'Non renseigné',
            'user_address_city' => !is_null($device->user->address) ? $device->user->address->address_city : 'Non renseigné',
            'user_address_postal_code' => !is_null($device->user->address) ? $device->user->address->address_postal_code : 'Non renseigné'
        ];
    }

    public function showVehicle($device_serial)
    {
        if(!($device = Device::where('device_serial_number', $device_serial)->first()))
            return ['status' => 'ERROR', 'response' => 'Device with serial "' . $device_serial . '" does not exist.'];

        if(!$device->user)
            return ['status' => 'ERROR', 'response' => 'Device with serial "' . $device_serial . '" has no user associated.'];

        if(!$device->vehicle)
            return ['status' => 'ERROR', 'response' => 'Device with serial "' . $device_serial . '" has no vehicle associated.'];

        return [
            'vehicle_name' => $device->vehicle->vehicle_name,
            'vehicle_brand' => !is_null($device->vehicle->vehicle_brand) ? $device->vehicle->vehicle_brand : 'Non renseigné',
            'vehicle_color' => $device->vehicle->vehicle_color,
            'vehicle_model' => !is_null($device->vehicle->vehicle_model) ? $device->vehicle->vehicle_model : 'Non renseigné',
            'vehicle_numberplate' => !is_null($device->vehicle->vehicle_numberplate) ? $device->vehicle->vehicle_numberplate : 'Non renseigné',
            'vehicle_type' => $device->vehicle->vehicle_type
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

    public function createCode($device_serial, $code)
    {
        if(!($device = Device::where('device_serial_number', $device_serial)->first()))
            return ['status' => 'ERROR', 'response' => 'Device with serial "' . $device_serial . '" does not exist.'];

        if(!is_null(Code::find($code)))
            return ['status' => 'ERROR', 'response' => 'The code "' . $code . '" already exists.'];

        $newCode = new Code();
        $newCode->code_code = $code;
        $newCode->device_id = $device->device_id;
        $newCode->save();

        return ['status' => 'OK', 'response' => 'Code added successfully.'];
    }
}
