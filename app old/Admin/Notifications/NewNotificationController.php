<?php
namespace App\Admin\Notifications;

use App\Http\Controllers\Controller;
use App\Admin\Notifications\Notification;
use App\Admin\Notifications\UserDevice;
use Illuminate\Http\Request;
class NewNotificationController extends Controller
{

    public function sendMessage(Request $request)
    {
        $registration_ids = [];

        $userDevices = UserDevice::where('user_id', request('user_id'))->where('active', 'on')->get();
        foreach ($userDevices as $device) {
            $registration_ids[] = $device->fcm_token;
        }

        Notification::create([
            'title' => auth()->user()->name,
            'user_id' => request('user_id'),
            'sender_id' => auth()->user()->id,
            'message' => request('body'),
            'type' => 'message'
        ]);

        if (count($registration_ids) > 0) {
            $this->sendNotification($request->all() ,$registration_ids);
        }
    }

    public function sendNotification($data,$registration_ids)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $firebase_key = 'AAAAMMjsTU0:APA91bG6m9BVlXewPRuN08OCwH9Mf-ioIIMbXfI8V-RcYIHazxVl_dtKBm_37CaSlmn6WMJLUdwkUVr51gTdhUKVtpm1Ts3_afFEtfoHIeCtZK2bH_VRAgnqUqwLbW9U-_YZW-mpuWyB';
        $fields = array (
            "notification" => array (
                'data' => [
                    'title' => auth()->user()->name,
                    'body' => $data['body'],
                ]
            ),
            "data" => array (
                'title' => auth()->user()->name,
                'receiver_id' => request('user_id'),
                'sender_id' => auth()->user()->id,
                'body' => $data['body'],
                'image_url' => auth()->user()->avatar,
                'sound' => 'default',
                'type' => 'Chat',
                'icon' => 'ic_launcher',
            ),
            'registration_ids' => $registration_ids,
            "priority" => "high"
        );
        
        $ch = curl_init ();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array (
            'Authorization: key='.$firebase_key,
            'Content-Type: application/json'
        ));
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode ($fields));
        $result = curl_exec ($ch);
        curl_close ($ch);
        return $result;
    }
}
