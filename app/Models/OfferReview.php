<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferReview extends Model
{
    protected $fillable = [
        'offer_id', 'user_id', 'comment', 'rate', 'reasons', 'status'
    ];

    protected $table = 'offer_reviews';

    public $timestamps = true;

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
