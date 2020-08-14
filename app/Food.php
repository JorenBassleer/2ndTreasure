<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    protected $fillable = ['type', 'value'];

    public function goodiebags()
    {
        return $this->belongsToMany('App\Goodiebag')->withTimestamps()->withPivot('amount');
    }
}
