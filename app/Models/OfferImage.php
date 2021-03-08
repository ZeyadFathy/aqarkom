<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferImage extends Model
{
    protected $fillable = [
        'offer_id', 'image'
    ];

    protected $table = 'offer_images';

    public $timestamps = true;

    public function image()
    {
        return $this->belongsTo(Offer::class);
    }
}
