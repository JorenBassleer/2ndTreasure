<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeeklyLeaderBoard extends Model
{
    protected $fillable =[
        'user_id', 'amount_of_kg',
    ];
    protected $primaryKey = "id";
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}