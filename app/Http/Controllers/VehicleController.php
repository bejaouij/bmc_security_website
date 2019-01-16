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
        $newVehicle->user_id = Auth::user()->user_id;
        $newVehicle->save();

        $vehicleStatus = new VehicleStatus();
        $vehicleStatus->status_code = STATUS_CODE_OK;
        $vehicleStatus->vehicle_id = $newVehicle->vehicle_id;
        $vehicleStatus->save();

        return redirect()->back();
    }

    public function edit(Request $request, int $id) {
        $vehicle = Vehicle::findOrFail($id);

        if($vehicle->user_id != Auth::user()->user_id)
            abort(404);

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

        $vehicle->vehicle_name = $validator['vehicle_name'];
        $vehicle->vehicle_brand = $validator['vehicle_brand'];
        $vehicle->vehicle_model = $validator['vehicle_model'];
        $vehicle->vehicle_numberplate = $vehicleNumberplate;
        $vehicle->vehicle_type = $validator['vehicle_type'];
        $vehicle->vehicle_color = $validator['vehicle_color'];
        $vehicle->save();

        return redirect()->back();
    }

    /**
     * Remove the vehicle and its related elements and redirect back.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(int $id) {
        $vehicle = Vehicle::findOrFail($id);

        if($vehicle->user_id != Auth::user()->user_id)
            abort(404);

        $vehicle->vehicleStatuses->map(function($vehicleToDelete) {
            $vehicleToDelete->delete();
        });

        $vehicle->delete();

        return redirect()->back();
    }
}
