<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculationItem extends Model
{
    protected $fillable = [
        'calculation_id', 'item_id', 'num'
    ];

    public function calculation()
    {
        return $this->belongsTo(Calculation::class);
    }

    public function item()
    {
        return $this->belongsTo(BuildingItem::class);
    }
}
