<?php

namespace App\Admin\Tracking;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Users\User;

class Tracking extends Model {

    protected $fillable = [
        'user_id', 'end_at', 'ads_number', 'social_media', 'featured_ads_number', 'mobile_notification','available_ads'
    ];

    protected $table = 'bouquet_trackings';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // public function priceAfterDiscount()
    // {
    //     if ($this->discount > 0 && $this->discount_end_date >= Carbon::today()) {
    //         return (100 - $this->discount) * $this->price / 100;
    //     }
    //     return $this->price;
    // }
}