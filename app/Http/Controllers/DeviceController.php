<?php

namespace App\Http\Controllers;

use App\Device;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function associateVehicle(int $device_id, int $vehicle_id) {
    	$vehicle = Vehicle::findOrFail($vehicle_id);

    	if($vehicle->user_id != Auth::user()->user_id)
    	    abort(404);

        $device = Device::findOrFail($device_id);

        if($device->user_id != Auth::user()->user_id)
            abort(404);

        $device->vehicle_id = $vehicle_id;
        $device->save();

    	return redirect()->back()->with('success', 'Véhicule associé au dispositif avec succès.');
    }
}
