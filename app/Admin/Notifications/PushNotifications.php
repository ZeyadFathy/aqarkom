<?php

namespace App\Admin\Notifications;

use App\Http\Controllers\Controller;

class PushNotifications extends Controller {

	public static function sendMessage( $message, $device_tokens, $data = null) {
		$content = [ 'en' => $message ];
		$fields  = array(
			'app_id'             => env( 'ONE_SIGNAL_ID' ),
			'include_player_ids' => $device_tokens,
			'data'              => (!empty($data)? $data:''),
			'contents'           => $content
		);

		$fields = json_encode( $fields );
		$ch     = curl_init();
		curl_setopt( $ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications" );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json; charset=utf-8',
			'Authorization: Basic ' . env( 'ONE_SIGNAL_KEY' )
		) );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

		$response = curl_exec( $ch );
		curl_close( $ch );

		return $response;
	}

	public static function sendNotificationToAll($message)
    {
        $content = $content = ['en' => $message];
        $fields = array(
            'app_id' => env('ONE_SIGNAL_ID'),
            'included_segments' => array(
                'All',
            ),
            'contents' => $content,
            'ios_badgeType' => 'Increase',
            'ios_badgeCount' => 1
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . env('ONE_SIGNAL_KEY'),
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

}
