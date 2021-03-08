<?php

namespace App\Admin\Cities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    //
	use SoftDeletes;

    protected $hidden = ['deleted_at'];

    protected $table = 'regions';
    
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}