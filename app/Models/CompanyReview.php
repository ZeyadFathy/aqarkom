<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyReview extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id', 'user_id', 'comment', 'rate', 'status'
    ];

    protected $table = 'company_review';

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
