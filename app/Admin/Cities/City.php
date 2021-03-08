<?php

namespace App\Admin\Cities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    //
    use SoftDeletes;

    protected $hidden = ['deleted_at'];

    protected $table = 'cities';

    public function regions()
    {
        return $this->hasMany(Region::class, 'city_id');
    }
}
