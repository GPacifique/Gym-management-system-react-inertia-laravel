<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            env('TWILIO_SID'),
            env('TWILIO_TOKEN')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Send SMS
    |--------------------------------------------------------------------------
    */
    public function sendSms($phone, $message)
    {
        return $this->client->messages->create(
            $phone,
            [
                'from' => env('TWILIO_PHONE'),
                'body' => $message,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Send WhatsApp
    |--------------------------------------------------------------------------
    */
    public function sendWhatsApp($phone, $message)
    {
        return $this->client->messages->create(
            "whatsapp:" . $phone,
            [
                'from' => env('TWILIO_WHATSAPP'),
                'body' => $message,
            ]
        );
    }
}