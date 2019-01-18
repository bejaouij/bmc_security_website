<?php

namespace App;

use App\Position;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'device';
    protected $primaryKey = 'device_id';
    public $timestamps = false;

    protected $fillable = [
        'device_name'
    ];

    public function lastPositions() {
        return Position::where('device_id', $this->device_id)->first();
    }
}
