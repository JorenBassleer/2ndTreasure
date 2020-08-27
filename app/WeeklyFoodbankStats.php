<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeeklyFoodbankStats extends Model
{
    protected $fillable = [
        'user_id', 'amount_of_kg_received',
        'amount_of_treasures_generated', 'amount_of_goodiebags_received'
    ];
    public function foodbank()
    {
        return $this->belongsTo('App\User');
    }
}
