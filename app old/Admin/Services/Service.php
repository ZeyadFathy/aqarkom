<?php

namespace App\Admin\Services;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
	use SoftDeletes;

    protected $hidden = ['deleted_at'];
	protected $table = 'services';
}
