<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildingLocation extends Model
{
    protected $fillable = [
        'title_ar', 'title_en'
    ];

    public function items()
    {
        return $this->hasMany(BuildingItem::class, 'location_id');
    }
}
