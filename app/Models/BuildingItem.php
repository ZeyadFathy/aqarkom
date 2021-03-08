<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildingItem extends Model
{
    protected $fillable = [
        'title_ar', 'title_en', 'location_id', 'multiple'
    ];

    public function location()
    {
        return $this->belongsTo(BuildingLocation::class, 'location_id');
    }

    public function companyPrices()
    {
        return $this->hasMany(CompanyPrice::class, 'item_id');
    }
}
