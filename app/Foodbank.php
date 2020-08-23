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
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
