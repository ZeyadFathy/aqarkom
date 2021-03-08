<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['fullname', 'email', 'phone', 'cv', 'seen', 'career_id', ];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }
}
