<?php

namespace App\Services;

use AfricasTalking\SDK\AfricasTalking;

class SmsService
{
    protected $sms;

    public function __construct()
    {
        $username = env('AT_USERNAME');
        $apiKey = env('AT_API_KEY');

        $AT = new AfricasTalking($username, $apiKey);
        $this->sms = $AT->sms();
    }

    public function sendSms($phone, $message)
    {
        return $this->sms->send([
            'to' => $phone,
            'message' => $message,
            'from' => env('AT_SENDER_ID')
        ]);
    }
}