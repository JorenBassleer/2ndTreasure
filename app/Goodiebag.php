<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goodiebag extends Model
{
    protected $fillable = ['foodbank_id','user_id', 'status_id'];
    public function foods()
    {
        return $this->belongsToMany('App\Food')->withTimestamps()->withPivot('amount');
    }
}
