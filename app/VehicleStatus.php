<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleStatus extends Model
{
    protected $table = 'vehicle_status';
    protected $primaryKey = 'status_code';
    public $timestamps = false;
}
