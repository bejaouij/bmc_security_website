<?php

namespace App;

use App\Device;
use App\VehicleStatus;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicle';
    protected $primaryKey = 'vehicle_id';
    public $timestamps = false;

    protected $fillable = [
        'vehicle_name',
        'vehicle_brand',
        'vehicle_model',
        'vehicle_numberplate',
        'vehicle_type',
        'vehicle_color',
        'user_id',
    ];

    /**
     * Retrieve the vehicle last status.
     *
     * @return \App\VehicleStatus
     */
    public function lastStatus(): VehicleStatus {
        return VehicleStatus::where('vehicle_id', $this->vehicle_id)->orderBy('date_date', 'DESC')->first();
    }

    public function vehicleStatuses() {
        return $this->hasMany('App\VehicleStatus', 'vehicle_id', 'vehicle_id');
    }

    public function device() {
        return $this->belongsTo('\App\Device', 'vehicle_id', 'vehicle_id');
    }
}
