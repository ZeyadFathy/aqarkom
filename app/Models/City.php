<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_cities', 'company_id', 'city_id');
    }
}
