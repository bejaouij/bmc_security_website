<?php

namespace App\Http\Controllers;

use App\Get;
use App\Device;
use App\Status;
use App\Vehicle;
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
        $devices = Device::where('user_id', Auth::user()->user_id)->get();

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
        return view('vehicle');
    }

    public function activity()
    {
        return view('activity');
    }

    public function photo()
    {
        return view('photo');
    }
}
