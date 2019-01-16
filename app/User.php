<?php

namespace App;

use App\Device;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_firstname',
        'user_lastname',
        'user_phone_number',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function devices() {
        return Device::where('user_id', $this->user_id)->get();
    }

    public function orderedActivity() {
        return Activity::where('user_id', $this->user_id)->orderBy('activity_date', 'DESC')->get();
    }
}
