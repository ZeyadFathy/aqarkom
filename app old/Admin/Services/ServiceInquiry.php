<?php

namespace App\Admin\Services;

use Illuminate\Database\Eloquent\Model;

class ServiceInquiry extends Model
{
    protected $table = 'service_form';

    protected $fillable = ['city', 'mobile', 'inquiry', 'service_id',];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
