<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foodbank extends Model
{
    protected $fillable = [
        'foodbank_name' ,'foodbank_email',
        'foodbank_address','foodbank_city',
        'foodbank_postalcode','foodbank_province',
        'foodbank_phone','company_number','details'
    ];
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps()->withPivot('role_id');
    }

    public function appeals()
    {
        return $this->hasMany('App\Appeal');
    }
}
