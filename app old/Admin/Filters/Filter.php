<?php

namespace App\Admin\Filters;

Use App\Admin\Filters\Option;
Use App\Admin\Categories\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Admin\Advertisements\AdsData;
use App\Admin\Advertisements\AdsTextData;

class Filter extends Model
{

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
