<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    protected $fillable = [
        'name', 'mobile', 'email', 'area', 'length', 'width', 'no_streets'
    ];

    public function items()
    {
        return $this->belongsToMany(
            BuildingItem::class,
            'calculation_items',
            'calculation_id',
            'item_id'
        );
    }

    public function calculationItems()
    {
        return $this->hasMany(CalculationItem::class, 'calculation_id');
    }
}
