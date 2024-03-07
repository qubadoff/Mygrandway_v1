<?php

namespace App\Services;

use Twilio\Rest\Client;

class SmsService
{

    public function __construct(protected readonly Client $client)
    {
    }

    public function send(string $phone, string $message): void
    {
        $this->client->messages->create(
            $phone,
            [
                'from' => config('services.twilio.from'),
                'body' => $message,
            ]
        );
    }


    public static function createFromContainer() : static
    {
        return app(static::class);
    }
}
