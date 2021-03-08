<?php

namespace App\Admin\Advertisements;

use Illuminate\Database\Eloquent\Model;


class AdView extends Model
{

    protected $table = 'ad_views';

    protected $fillable = ['ad_id', 'views'];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class, 'ad_id');
    }
}
