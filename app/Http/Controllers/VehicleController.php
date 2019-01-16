<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\VehicleStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

define('STATUS_CODE_SUSPECT_ACTIVITY', '3');
define('STATUS_CODE_STOLEN', '4');
define('STATUS_CODE_OK', '5');

class VehicleController extends Controller
{
    public function add(Request $request) {
        $validator = $request->validate([
            'vehicle_name' => 'required|max:50',
            'vehicle_brand' => 'required|max:25',
            'vehicle_model' => 'max:50',
            'vehicle_numberplate_part1' => 'nullable|size:2',
            'vehicle_numberplate_part2' => 'nullable|size:3',
            'vehicle_numberplate_part3' => 'nullable|size:2',
            'vehicle_type' => 'required|max:20',
            'vehicle_color' => 'required|max:50'
        ]);

        $vehicleNumberplate = null;

        if(!empty($validator['vehicle_numberplate_part1']) && !empty($validator['vehicle_numberplate_part2']) && !empty($validator['vehicle_numberplate_part3']))
            $vehicleNumberplate = strtoupper($validator['vehicle_numberplate_part1'] . $validator['vehicle_numberplate_part2'] . $validator['vehicle_numberplate_part3']);

        $newVehicle = new Vehicle();
        $newVehicle->vehicle_name = $validator['vehicle_name'];
        $newVehicle->vehicle_brand = $validator['vehicle_brand'];
        $newVehicle->vehicle_model = $validator['vehicle_model'];
        $newVehicle->vehicle_numberplate = $vehicleNumberplate;
        $newVehicle->vehicle_type = $validator['vehicle_type'];
        $newVehicle->vehicle_color = $validator['vehicle_color'];
        $newVehicle->user_id = 1;
        $newVehicle->save();

        $vehicleStatus = new VehicleStatus();
        $vehicleStatus->status_code = STATUS_CODE_OK;
        $vehicleStatus->vehicle_id = $newVehicle->vehicle_id;
        $vehicleStatus->save();

        return redirect()->back();
    }
}
