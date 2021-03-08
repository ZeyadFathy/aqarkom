<?php

namespace App\Admin\Bouquet;

use Illuminate\Database\Eloquent\Model;

class Bouquet extends Model {

    protected $fillable = [
        'name_en', 'name_ar', 'price', 'discount', 'discount_end_date', 'period', 'ads_number', 'free_period',
        'photos_services', 'social_media', 'featured_ads_number', 'mobile_notification', 'color'
    ];

    protected $table = 'bouquets';

    public function priceAfterDiscount()
    {
        if ($this->discount > 0 && $this->discount_end_date >= Carbon::today()) {
            return (100 - $this->discount) * $this->price / 100;
        }
        return $this->price;
    }
}