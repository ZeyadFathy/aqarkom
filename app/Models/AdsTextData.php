<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdsTextData extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'filter_id', 'advertisement_id', 'text'
    ];

	protected $table = 'ads_data_text';
    protected $hidden = ['deleted_at'];

    public function advertisement(){
		return $this->belongsTo(Advertisement::class,'advertisement_id');
	}
	public function adfilter(){
		return $this->belongsTo(Filter::class,'filter_id');
	}
}
