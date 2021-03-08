<?php

namespace App\Admin\Categories;

use App\Admin\Advertisements\Advertisement;
use App\Admin\Filters\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $table = 'categories';

	public function getIconAttribute($icon)
    {
		if($icon) {
			return 'http://aqarito.com/uploads/'.$icon;
		} 
		return "";
	}
	
	public function ads(){
		return $this->hasMany(Advertisement::class,'category_id');
    }
    
    public function filters(){
		return $this->hasMany(Filter::class,'category_id');
	}

}
