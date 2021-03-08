<?php

namespace App\Admin\Advertisements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Admin\Filters\Filter;
use App\Admin\Advertisements\Advertisement;

class AdsTextData extends Model
{
    use SoftDeletes;

	protected $table = 'ads_data_text';
    protected $hidden = ['deleted_at'];

	public function advertisement(){
		return $this->belongsTo(Advertisement::class,'advertisement_id');
	}
	public function adfilter(){
		return $this->belongsTo(Filter::class,'filter_id');
	}
}
