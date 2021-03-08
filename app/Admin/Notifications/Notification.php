<?php

namespace App\Admin\Notifications;

use App\Admin\Messages\Conversation;
use App\Admin\Users\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $table = 'notifications';

	protected $fillable = [
        'title', 'user_id', 'sender_id', 'message', 'type', 'read_at'
    ];

	public function user(){
		return $this->belongsTo(User::class,'user_id');
	}

	public function message(){
		return $this->belongsTo(Conversation::class,'conversation_id');
	}

	public function notifier_user(){
		return $this->belongsTo(User::class,'notifier');
	}

	public function getCreatedAtAttribute( $created ) {
		if ( request()->route() && request()->route()->getPrefix() == 'api' ) {
			return strtotime( $created );
		}

		return $created;
	}
}
