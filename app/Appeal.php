<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    protected $fillable = ['foodbank_id','user_id', 'status_id', 'goodiebag_id', 'hasUserRead', 'hasFoodbankRead'];

    public function foodbank()
    {
        return $this->belongsTo('App\Foodbank');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    public function goodiebag()
    {
        return $this->belongsTo('App\Goodiebag');
    }
}
