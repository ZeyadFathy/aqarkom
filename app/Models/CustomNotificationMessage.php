<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomNotificationMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'c_index', 'title', 'body'
    ];

    protected $table = 'custom_notification_messages';
}
