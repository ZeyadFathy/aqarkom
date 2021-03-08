<?php

namespace App\Admin\Users;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $fillable = [
        'mobile', 'otp', 'verified'
    ];
    
    protected $table = 'otp';
}
