<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeekStats extends Model
{
    protected $fillable =['amount_of_foodbanks', 'amount_of_users', 'amount_of_kg_donated', 'amount_of_treasures_created'];
}
