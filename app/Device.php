<?php

namespace App;

use App\Position;
use App\Photo;
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

    public function photos() {
        return Photo::where('device_id', $this->device_id)->orderBy('photo_date', 'DESC')->get();
    }
}
