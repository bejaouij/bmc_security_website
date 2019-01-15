<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'device';
    protected $primaryKey = 'device_id';
    public $timestamps = false;

    protected $fillable = [
        'device_name'
    ];
}
