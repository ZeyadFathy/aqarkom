<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Spatie\MediaLibrary\HasMedia;
//use Spatie\MediaLibrary\InteractsWithMedia;

class Company extends Model //implements HasMedia
{
    //use InteractsWithMedia;

    protected $fillable = [
        'title_ar', 'title_en', 'description_ar', 'description_en', 'category_id', 'city_id', 'contact_number', 'email',
        'facebook', 'instagram', 'twitter', 'website', 'days', 'days_en', 'image', 'lat', 'long', 'csr', 'status', 'featured', 'location'
    ];

    protected $table = 'companies';

    public $timestamps = true;

    // public function getImageAttribute()
    // {
    //     return $this->getFirstMediaUrl('companyLogo');
    // }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function reviews()
    {
        return $this->hasMany(CompanyReview::class);
    }

    public function category()
    {
        return $this->belongsTo(CompanyCategory::class, 'category_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'company_cities', 'city_id', 'company_id');
    }

    public function companyPrices()
    {
        return $this->hasMany(CompanyPrice::class);
    }
}
