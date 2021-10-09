<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'member_profiles';

    protected $primaryKey = 'user_id';
}
