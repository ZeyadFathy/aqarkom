<?php

namespace App\Admin\ContactUs;

use App\Admin\Users\User;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
	protected $table = 'contact_us';

	protected $fillable = ['title','name','message','user_id','email','phone'];
	public function user(){
		return $this->belongsTo(User::class,'user_id');
	}
}
