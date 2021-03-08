<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filter extends Model
{
    use SoftDeletes;
    
    protected $table = 'ads_filters';
    protected $dates = ['deleted_at'];

    public function category(){
		return $this->belongsTo(Category::class,'category_id');
	}

	public function options(){
		return $this->hasMany(FilterOption::class,'filter_id');
	}
	public function filteroptions(){
		return $this->hasMany(AdsData::class,'filter_id');
	}
	public function filtertextoptions(){
		return $this->hasMany(AdsTextData::class,'filter_id');
	}
}
