<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    protected $fillable = [
        'title_ar', 'title_en'
    ];

    protected $table = 'company_categories';

    public function companies()
    {
        return $this->hasMany(Company::class, 'category_id');
    }
}
