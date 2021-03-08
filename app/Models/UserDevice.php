<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    public $table    = 'user_devices';
    public $fillable = ["fcm_token","active","user_id"];
}
