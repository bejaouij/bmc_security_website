<?php

namespace App;

use App\VehicleStatus;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicle';
    protected $primaryKey = 'vehicle_id';
    public $timestamps = false;

    /**
     * Retrieve the vehicle last status.
     *
     * @return \App\VehicleStatus
     */
    public function lastStatus(): VehicleStatus {
        return VehicleStatus::where('vehicle_id', $this->user_id)->orderBy('date_date', 'DESC')->first();
    }
}
