<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title', 'user_id', 'sender_id', 'message', 'type', 'read_at'
    ];

    protected $table = 'notifications';

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
