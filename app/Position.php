<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'position';
    protected $primaryKey = 'position_id';
    public $timestamps = false;
}
