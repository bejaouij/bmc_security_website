<?php

namespace App\Http\Controllers;

use App\Get;
use App\Code;
use App\Status;
use App\Device;
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

//        return [
//            'status_code' => Status::find($deviceLastStatus->status_code),
//            'vehicle_status' => $device->vehicle->lastStatus()->status->status_code,
//            'in_disabling' => !is_null(Code::where('device_id', $device->device_id)->andWhere('code_is_used', false)->first())
//        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
}
