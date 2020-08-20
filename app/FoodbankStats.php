<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodbankStats extends Model
{
    protected $fillable = ['foodbank_id', 'total_amount_of_kg_received', 'total_amount_of_treasures_generated', 'total_amount_of_goodiebags_received'];

    public function foodbank()
    {
        return $this->belongsTo('App\User', 'foodbank_id', 'id');
    }
}
