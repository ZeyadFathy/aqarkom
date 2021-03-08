<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationToken extends Model
{
    public $table  = "notifications_tokens";
    public $timestamps = false;
    public $fillable = ["fcm_token"];
}
