<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Offer extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'company_id', 'name_ar', 'name_en', 'price', 'discount', 'discount_end_date',
        'desc_ar', 'desc_en'
    ];

    protected $table = 'offers';

    public $timestamps = true;

    protected $appends = ['priceAfterDiscount', 'rate'];

    public function getPriceAfterDiscountAttribute()
    {
        if ($this->discount > 0 && $this->discount_end_date > Carbon::today()) {
            return (100 - $this->discount) * $this->price / 100;
        }
        return $this->price;
    }

    public function getRateAttribute()
    {
        $reviews = $this->reviews;
        $total = $this->reviews->sum('rate');
        $count = count($this->reviews);

        return ($count == 0) ? 0 : $total/$count;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function images()
    {
        return $this->hasMany(OfferImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(OfferReview::class);
    }

    public function offerTransaction()
    {
        return $this->hasMany(OfferTransaction::class);
    }
}
