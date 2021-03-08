<?php

namespace App\Admin\Messages;

use App\Admin\Notifications\Notification;
use App\Admin\Users\User;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Admin\Notifications\PushNotifications;
use App\Admin\Notifications\UserDevice;

class MessageAPIController extends Controller
{
    public $helper;

    public function __construct()
    {
        $this->helper = new ApiHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->helper->validate(request(), ['user_id' => 'required']);

        $user_id = request('user_id');
        $messages = Conversation::where('user_two', $user_id)->orWhere('user_one', $user_id)
            ->with([
                'lastMessage:id,text,user_id,conversation_id,updated_at,type', 'lastMessage.user:id,name,avatar',
            ])
            ->withCount('new_msgs as new')
            ->orderBy('created_at', 'desc')->get()->map(function ($item) {
                $item->second = $item->second;
                return $item;
            });
        return $this->helper->paginate($messages, 20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->helper->validate($request, [
            'text' => 'required',
            'receiver_id' => 'required',
        ]);
        $user_id = $request->user_id;
        $receiver_id = $request->receiver_id;

        $conversation = Conversation::where([
            'user_one' => $user_id,
            'user_two' => $receiver_id,
        ])
            ->orWhere(function ($query) use ($user_id, $receiver_id) {
                $query->where('user_one', $receiver_id);
                $query->where('user_two', $user_id);
            })
            ->first();

        if (!$conversation) {
            $conversation = new Conversation();
            $conversation->user_one = $user_id;
            $conversation->user_two = $receiver_id;
            $conversation->save();
        }

        $message = new Message();

        $request->request->add(['conversation_id' => $conversation->id]);
        $this->setMessageData($request, $message);

        $message->save();
        $notifier = User::find($request->user_id);
        $notification = new Notification();
        $obj = new \stdClass();
        $user = User::find($request->receiver_id);
        $obj->user_id = $request->receiver_id;
        $obj->conversation_id = $conversation->id;
        $obj->notifier = $request->user_id;

        $obj->title_ar = Lang::get('admin.notifications.message', [
            'user_name' => $notifier->name,
        ], 'ar');
        $obj->title_en = Lang::get('admin.notifications.message', [
            'user_name' => $notifier->name,
        ], 'en');

        $data = [
            'type' => 1,
            'conversation_id' => $obj->conversation_id
        ];
        PushNotifications::sendMessage(
            $obj->title_ar,
            [$user->device_token],
            $data
        );

        $conversation->last = Carbon::now()->toDateTimeString();

        $conversation->update();
        
        
        
        
        
        
        
        $registration_ids = [];
        
        $sender = User::find($user_id);

        $userDevices = UserDevice::where('user_id', $user_id)->where('active', 'on')->get();
        foreach ($userDevices as $device) {
            $registration_ids[] = $device->fcm_token;
        }
        
        $url = 'https://fcm.googleapis.com/fcm/send';

        $data = [
            'priority' => 'high',
            'content_available' => true,
            'notification' => [
                'data' => [
                    'title' => $sender->name,
                    'body' => request('text'),
                ]
            ],
            'data' => [
                'title' => $sender->name,
                'body' => request('text'),
                'image_url' => '',
                'sound' => 'default',
                'type' => 'Chat',
                'icon' => 'ic_launcher',
            ],
            'registration_ids' => $registration_ids
        ];


        Http::withHeaders(['Content-type: application/json'])
            ->withToken('AAAAMMjsTU0:APA91bG6m9BVlXewPRuN08OCwH9Mf-ioIIMbXfI8V-RcYIHazxVl_dtKBm_37CaSlmn6WMJLUdwkUVr51gTdhUKVtpm1Ts3_afFEtfoHIeCtZK2bH_VRAgnqUqwLbW9U-_YZW-mpuWyB')
            ->post($url, $data);
        
        
        
        
        

        return $this->helper->output($message);
    }

    public function setMessageData(Request $request, Message &$message)
    {
        $message->type = $request->type;
        if ($message->type == 2) {
            $message->text = $this->helper->saveBase64Voice($request->text);
        } elseif ($message->type == 3) {
            $message->text = $this->helper->saveBase64Image($request->text['image'], $request->text['ext']);
        } else {
            $message->text = $request->text;
        }
        $message->user_id = $request->user_id;
        $message->conversation_id = $request->conversation_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $messages = Message::where('conversation_id', $id)->latest()->paginate(20);
        $conversation = Conversation::Where('id', $id)->first();
        $second = new \stdClass();
        $second = $conversation->second;

        Message::where('conversation_id', $id)->update(['seen' => true]);

        return response()->json([
            'data' => ['conversation' => $messages, 'second' => $second],
            'moreData' => $messages->hasMorePages(),
            'status' => 1,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_conversation(Request $request)
    {
        $this->helper->validate($request, [
            'second' => 'required',
            'user_id' => 'required',
        ]);
        $user_one = $request->user_id;
        $user_two = $request->second;
        $conversation = Conversation::where([
            'user_one' => $user_one,
            'user_two' => $user_two,
        ])
            ->orWhere(function ($query) use ($user_one, $user_two) {
                $query->where('user_one', $user_one);
                $query->where('user_two', $user_two);
            })
            ->first();

        if (!empty($conversation)) {
            return  $this->show($conversation->id);
        } else {
            return response()->json([
                'data' => 'لا يوجد محادثة',
                'status' => 1,
            ]);
        }
    }
}
