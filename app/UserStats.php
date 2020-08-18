<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStats extends Model
{
    protected $fillable = ['user_id', 'highest_place_ever', 'highest_place_this_week','highest_number_of_treasures','total_amount_of_kg_donated' ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
