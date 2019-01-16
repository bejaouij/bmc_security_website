<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activity';
    protected $primaryKey = 'activity_id';
    public $timestamps = false;
}
