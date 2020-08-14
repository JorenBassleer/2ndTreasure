<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function foodbankUsers()
    {
        return $this->belongsToMany('App\FoodbankUser')->withTimestamps();
    }
}
