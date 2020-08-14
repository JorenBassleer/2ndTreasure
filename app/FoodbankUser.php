<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodbankUser extends Model
{
    protected $table = 'foodbank_user';

    protected $fillable = ['foodbank_id', 'user_id', 'role_id'];
}
