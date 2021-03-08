<?php

namespace App\Helpers;
use Twilio\Rest\Client;


class TwilioHelper
{
    public function send($body, $to)
    {
        $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
        $client->messages->create(
            $to,
            array(
                'from' => "Aqarito App",
                'body' => $body
            )
        );
    }
}
