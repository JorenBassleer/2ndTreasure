<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeeklyUserStats extends Model
{
    protected $fillable = [
        'number_of_treasures', 'amount_of_kg_donated', 
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
