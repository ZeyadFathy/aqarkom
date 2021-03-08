<?php

namespace App\Admin\Messages;

use App\Admin\Advertisements\Advertisement;
use App\Admin\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
class Conversation extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'conversation';
	
	public function one(){
		return $this->belongsTo(User::class,'user_one');
	}

	public function two(){
		return $this->belongsTo(User::class,'user_two');
	}

	public function advertisement(){
		return $this->belongsTo(Advertisement::class,'advertisement_id');
	}

	public function messages(){
		return $this->hasMany(Message::class,'conversation_id');
	}

	public function lastMessage(){
		return $this->hasOne(Message::class,'conversation_id')->latest();
	}

	public function second(){
		if(request()->user_id == $this->user_one){
			return $this->belongsTo(User::class,'user_two')->select(['id', 'name', 'avatar']);
		}
		else {
			return $this->belongsTo(User::class,'user_one')->select(['id', 'name', 'avatar']);
		}
	}
	public function new_msgs(){
		return $this->hasMany(Message::class,'conversation_id')->where('seen',false);
	}
}
