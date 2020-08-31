<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeeklyUserStats extends Model
{
    protected $fillable = [
        'user_id','number_of_treasures', 'amount_of_kg_donated', 
        'created_at', 'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
