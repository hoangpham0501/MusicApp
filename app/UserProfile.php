<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'userprofile';
    protected $fillable = ['firstname', 'lastname', 'date','telephone'];
}

