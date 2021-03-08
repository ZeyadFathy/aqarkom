<?php

namespace App\Admin\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Admin\Advertisements\Advertisement;
use App\admin\Users\User;

class Report extends Model
{
    use SoftDeletes;

    protected $table = 'reports';

    public function ad()
    {
        return $this->belongsTo(Advertisement::class, 'ad_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
