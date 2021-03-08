<?php

namespace App\Admin\Messages;

use App\Admin\Advertisements\Advertisement;
use App\Admin\Comments\Comment;
use App\Admin\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    //
	use SoftDeletes;

    protected $hidden = ['deleted_at'];
	protected $table = 'messages';

	public function user(){
		return $this->belongsTo(User::class,'user_id');
	}

	public function conversation(){
		return $this->belongsTo(Conversation::class,'conversation_id');
	}

	public function getSeenAttribute($val){
		return $val ? true : false;
	}
	
	public function getTextAttribute($text)
    {
        if ($this->type == 1) {
			return $text;
        }
        elseif($this->type == 2){
			return request()->getSchemeAndHttpHost() .'/uploads/'.$text;

		}
		else
		{
			return request()->getSchemeAndHttpHost() .'/uploads/images/'.$text;

		}
    }
}
