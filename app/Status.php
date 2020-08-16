<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['status'];

    public function appeals()
    {
        return $this->hasMany('App\Appeal');
    }
}
