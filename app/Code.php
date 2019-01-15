<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $table = 'code';
    protected $primaryKey = 'code_code';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
}
