<?php
namespace App\Admin\Notifications;

use App\admin\Users\User;
class NotificationEloquent
{

    public function getRegistrationIds(array $ids, string $message)
    {
        $users = User::whereIn('account_type_id', $ids)->get();
        $registration_ids = [];

        foreach ($users as $user) {
            $userDevices = UserDevice::where('user_id', $user->id)->where('active', 'on')->get();
            foreach ($userDevices as $device) {
                $registration_ids[] = $device->fcm_token;
            }
            $this->store($user->id, $message);
        }

        return $registration_ids;
    }

    public function getRegistrationId(int $id, string $message)
    {
        $registration_ids = [];

        $userDevices = UserDevice::where('user_id', $id)->where('active', 'on')->get();
        foreach ($userDevices as $device) {
            $registration_ids[] = $device->fcm_token;
        }

        $this->storeMessage($id, $message);
        return $registration_ids;
    }

    public function store(int $id, string $message)
    {
        Notification::create([
            'title' => 'Aqarito',
            'user_id' => $id,
            'sender_id' => auth()->user()->id,
            'message' => $message,
            'type' => 'general'
        ]);
    }

    public function storeMessage(int $id, string $message)
    {
        Notification::create([
            'title' => auth()->user()->name,
            'user_id' => $id,
            'sender_id' => auth()->user()->id,
            'message' => $message,
            'type' => 'message'
        ]);
    }
}
