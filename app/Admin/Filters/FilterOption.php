<?php

namespace App\Admin\Filters;

use App\Admin\Filters\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FilterOption extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

	protected $table = 'ads_filter_options';

	public function ads_filter(){
		return $this->belongsTo(Filter::class,'filter_id');
	}

	public function scopeOfads_filter($query, $ads_filter)
    {
        return $query->where('filter_id', $ads_filter);
    }
}
