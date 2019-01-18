<?php

namespace App\Http\Controllers;

use App\Get;
use App\Device;
use App\Status;
use App\Vehicle;
use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function device()
    {
        $currentUser = Auth::user();
        $devices = $currentUser->devices();

        foreach($devices as $device) {
            $deviceLastStatus = Get::where('device_id', $device->device_id)
                ->orderBy('date_date', 'DESC')
                ->first();

            $device->lastStatus = Status::find($deviceLastStatus->status_code);

            $device->associatedVehicle = Vehicle::find($device->vehicle_id);
        }

        $vehicles = Vehicle::where('user_id', Auth::user()->user_id)->get();

        return view('device', compact(['devices', 'vehicles']));
    }

    public function vehicle()
    {
        $vehicles = Vehicle::where('user_id', Auth::user()->user_id)->get();

        foreach($vehicles as $vehicle) {
            $vehicle->lastStatus = $vehicle->lastStatus();
            $vehicle->numberplatePart1 = substr($vehicle->vehicle_numberplate, 0, 2);
            $vehicle->numberplatePart2 = substr($vehicle->vehicle_numberplate, 2, 3);
            $vehicle->numberplatePart3 = substr($vehicle->vehicle_numberplate, 5, 2);

            if($vehicle->device)
                $vehicle->lastPositions = $vehicle->device->lastPositions();
        }

        return view('vehicle', compact('vehicles'));
    }

    public function activity()
    {
        $activities = Auth::user()->orderedActivity();

        $activities->map(function($activity) {
           $activity->formattedDate =  date('d / m / Y - H\hi', strtotime($activity->activity_date));
        });

        return view('activity', compact('activities'));
    }

    public function photo()
    {
        return view('photo');
    }
}
