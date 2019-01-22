<?php

namespace App\Http\Controllers;

use App\Device;
use App\Position;
use App\Http\Resources\Position as PositionResource;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($device_serial)
    {
        $device = Device::where('device_serial_number', $device_serial)->first();

        if(!$device)
            return ['status' => 'ERROR', 'response' => 'Device with serial "' . $device_serial . '" does not exist.'];

        return [
            'position_x' => !is_null($device->lastPositions()->position_x) ? $device->lastPositions()->position_x : 'Non renseigné',
            'position_y' => !is_null($device->lastPositions()->position_y) ? $device->lastPositions()->position_y : 'Non renseigné'
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $device_serial, $x, $y)
    {
        $device = Device::where('device_serial_number', $device_serial)->first();

        if($device) {
            $position = new Position();
            $position->position_x = $x;
            $position->position_y = $y;
            $position->device_id = $device->device_id;
            $position->save();

            return ['status' => 'OK', 'response' => 'Positions successfully added', 'object' => $position];
        }

        return ['status' => 'ERROR', 'response' => 'Device with serial "' . $device_serial . '" does not exist.'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
