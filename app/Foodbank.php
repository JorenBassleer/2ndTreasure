<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\UserInterface;

class Foodbank extends Authenticatable
{
    protected $fillable = [
        'user_id' ,
        'company_number','details',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }
    public function getAuthPassword()
    {
        return $this->password;
    }
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
    // public function users()
    // {
    //     return $this->belongsToMany('App\User')->withTimestamps()->withPivot('role_id');
    // }

    // public function appeals()
    // {
    //     return $this->hasMany('App\Appeal');
    // }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function foodbankstat()
    {
        return $this->hasOne('App\FoodbankStats');
    }
}
