<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Get extends Model
{
    protected $table = 'get';
    protected $primaryKey = 'status_code';
    public $timestamps = false;
}
