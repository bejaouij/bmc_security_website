<?php

namespace App\Http\Controllers;

use App\Device;
use App\Vehicle;
use App\Get;
use App\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

define('STATUS_CODE_DISABLED', '0');
define('STATUS_CODE_ENABLED', '1');
define('STATUS_CODE_DISABLING', '2');

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

    public function add(Request $request) {
        $validator = $request->validate([
            'device_serial_number_part_1' => 'required|min:4|max:4',
            'device_serial_number_part_2' => 'required|min:4|max:4',
            'device_serial_number_part_3' => 'required|min:4|max:4',
            'device_name' => 'required|min:1|max:50'
        ]);

        $deviceSerialNumber = strtoupper($validator['device_serial_number_part_1'] . $validator['device_serial_number_part_2'] . $validator['device_serial_number_part_3']);

        if(is_null($device = Device::where('device_serial_number', $deviceSerialNumber)->first()))
            return redirect()->back()->with('error', 'La clef est invalide.');
        if(!is_null($device->user_id)) {
            return redirect()->back()->with('error', 'La clef a déjà été utilisée.');
        }

        $device->user_id = Auth::user()->user_id;
        $device->device_name = $validator['device_name'];

        $deviceStatus = new Get();
        $deviceStatus->status_code = '0';
        $deviceStatus->device_id = $device->device_id;

        $device->save();
        $deviceStatus->save();

        return redirect()->back()->with('success', 'Dispositif ajouté avec succès.');
    }

    public function enable(int $id) {
        Device::findOrFail($id);

        $deviceStatus = new Get();
        $deviceStatus->status_code = STATUS_CODE_ENABLED;
        $deviceStatus->device_id = $id;
        $deviceStatus->save();

        return redirect()->back();
    }

    public function disable(int $id) {
        Device::findOrFail($id);

        $deviceStatus = new Get();
        $deviceStatus->status_code = STATUS_CODE_DISABLED;
        $deviceStatus->device_id = $id;
        $deviceStatus->save();

        return redirect()->back();
    }

    public function disabling(Request $request, int $id) {
        $validator = $request->validate([
            'code_code' => 'required|string|min:5|max:5'
        ]);

        Device::findOrFail($id);

        if(is_null($code = Code::find($validator['code_code'])))
            return redirect()->back()->with('error', 'Le code saisi est invalide.');

        if($code->device_id != $id)
            return redirect()->back()->with('error', 'Le code saisi est invalide.');

        if($code->code_is_used == true)
            return redirect()->back()->with('error', 'Le code a déjà été utilisé.');

        $deviceStatus = new Get();
        $deviceStatus->status_code = STATUS_CODE_DISABLED;
        $deviceStatus->device_id = $id;
        $deviceStatus->save();

        $code->code_is_used = true;
        $code->save();

        return redirect()->back();
    }

    public function dissociate($id) {
        $device = Device::findOrFail($id);

        $device->vehicle_id = null;
        $device->save();

        return redirect()->back();
    }
}
