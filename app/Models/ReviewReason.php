<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewReason extends Model
{
    protected $fillable = [
        'rate', 'reason_ar', 'reason_en', 'type', 'for_type'
    ];

    protected $table = 'review_reasons';

    public $timestamps = true;
}
