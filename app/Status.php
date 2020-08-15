<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['status'];

    public function goodiebags()
    {
        return $this->belongsTo('App\Goodiebag');
    }
}
