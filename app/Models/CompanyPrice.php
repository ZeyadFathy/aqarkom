<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyPrice extends Model
{
    protected $fillable = [
        'company_id', 'item_id', 'price'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function item()
    {
        return $this->belongsTo(BuildingItem::class, 'item_id');
    }
}
