<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleStatus extends Model
{
    protected $table = 'vehicle_status';
    protected $primaryKey = 'vehicle_id';
    public $timestamps = false;

    protected $fillable = [
        'vehicle_id',
        'status_code'
    ];

    public function status() {
        return $this->hasOne('App\Status', 'status_code', 'status_code');
    }
}
