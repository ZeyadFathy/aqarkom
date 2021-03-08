<?php

namespace App\Admin\BankForm;

use App\Admin\Users\User;
use Illuminate\Database\Eloquent\Model;

class BankForm extends Model
{
    //
	protected $table = 'bank_form';

	public function user(){
		return $this->belongsTo(User::class,'user_id');
	}
}
