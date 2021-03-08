<?php

namespace App\Admin\Rental;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
	use SoftDeletes;

    protected $hidden = ['deleted_at'];
	protected $table = 'rental';
}
