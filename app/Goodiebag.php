<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goodiebag extends Model
{
    protected $fillable = ['foodbank_id','user_id', 'status_id', 'code', 'hasReceived', 'total_kg'];
    public function foods()
    {
        return $this->belongsToMany('App\Food')->withTimestamps()->withPivot('amount');
    }

    public function foodbank()
    {
        return $this->belongsTo('App\User', 'foodbank_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
