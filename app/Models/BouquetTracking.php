<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BouquetTracking extends Model
{
    protected $fillable = [
        'user_id', 'end_at', 'ads_number', 'photo_services', 'social_media', 'featured_ads_number',
        'mobile_notification'
    ];

    protected $table = 'bouquet_trackings';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
