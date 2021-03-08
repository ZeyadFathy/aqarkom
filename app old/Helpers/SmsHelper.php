<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class SmsHelper
{

    public const API_URL = 'http://api.yamamah.com/SendSMSV2';

    public function send($message, $mobile): void
    {

        $url = $this->createSendUrl($mobile, $message);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: plain/text']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // execute!
        $response = curl_exec($ch);
        // close the connection, release resources used
        curl_close($ch);
        $response = json_decode($response);
        Log::notice($response);
    }

    private function createSendUrl(string $number, string $message): string
    {
        $message = urlencode($message);

        $getParameters = '?Username=' . env('SMS_USER') . '&Password=' . env('SMS_PASS') . '&Tagname=' . env('SMS_TAG') . '&RecepientNumber=' . $number . '&Message=' . $message . '&SendDateTime=0&EnableDR=true&SentMessageID=true';
        return $this::API_URL . $getParameters;
    }
}
