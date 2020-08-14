<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodGoodiebag extends Model
{
    protected $table = 'food_goodiebag';

    protected $fillable = ['food_id', 'goodiebag_id', 'amount'];
}
