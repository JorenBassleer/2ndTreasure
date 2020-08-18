<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
        'address','city',
        'postalcode','phone',
        'province', 'password',
        'country', 'treasures',
        'lat', 'lng',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // public function foodbanks()
    // {
    //     return $this->belongsToMany('App\Foodbank')->withTimestamps()->withPivot('role_id');
    // }
    // public function appeals()
    // {
    //     return $this->hasMany('App\Appeal');
    // }

    public function userStat()
    {
        return $this->hasOne('App\UserStats');
    }
    public function foodbank()
    {
        return $this->hasOne('App\Foodbank');
    }
}
