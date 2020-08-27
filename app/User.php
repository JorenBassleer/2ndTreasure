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
        'lat', 'lng', 'isFlagged',
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

    public function goodiebags()
    {
        return $this->hasMany('App\Goodiebag');
    }
    public function userstat()
    {
        return $this->hasOne('App\UserStats');
    }
    public function weeklyuserstats()
    {
        return $this->hasMany('App\WeeklyUserStats');
    }
    public function foodbankstat()
    {
        return $this->hasOne('App\FoodbankStats');
    }
    public function weeklyfoodbankstats()
    {
        return $this->hasMany('App\WeeklyFoodbankStats');
    }
    public function foodbank()
    {
        return $this->hasOne('App\Foodbank');
    }
    public function weeklyleaderboard()
    {
        return $this->hasOne('App\WeeklyLeaderBoard');
    }
    public function alltimeleaderboard()
    {
        return $this->hasOne('App\AllTimeLeaderBoard');
    }

    public function scopeOnlyNormalUsers($query)
    {
        return $query->where('isFoodbank', null)
                     ->orWhere('isFoodbank', 0);
    }
    public function scopeOnlyFoodbanks($query)
    {
        return $query->where('isFoodbank', 1);
    }
}
