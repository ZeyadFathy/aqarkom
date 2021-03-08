<?php

namespace App\Admin\Advertisements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Admin\Filters\Filter;
use App\Admin\Filters\FilterOption;

class AdsData extends Model
{
    use SoftDeletes;

    protected $hidden = ['deleted_at'];

	protected $table = 'ads_data';

    protected $fillable = ['filter_id', 'option'];

	public function advertisement(){
		return $this->belongsTo(Advertisement::class,'advertisement_id');
	}
	public function adfilter(){
		return $this->belongsTo(Filter::class,'filter_id');
	}
	public function adoption(){
		return $this->belongsTo(FilterOption::class,'option_id');
	}
	public function filteroptions(){
		return $this->hasMany(AdsData::class,'filter_id');
	}
	public function DataDetails(){
		if($this->filter->type != 1)
		{
		return	$this->filteroptions = AdsData::where('filter_id',$this->filter_id)
			->where('advertisement_id',$this->advertisement_id);
		}
		else{
			return null;
		}
	}
}
