<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllTimeLeaderBoard extends Model
{
    protected $fillable =[
        'user_id', 'amount_of_kg',
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
