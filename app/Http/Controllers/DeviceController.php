<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function associateVehicle(Request $request) {
    	dd($request);

    	return redirest()->back()->with('success', 'Véhicule associé au dispositif avec succès.');
    }
}
