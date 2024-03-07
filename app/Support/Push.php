<?php

namespace App\Support;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Throwable;
use Twilio\Http\Response;

class Push
{
    public const BULK_CLIENT_KEY = 'registration_ids';

    public const SINGLE_CLIENT_KEY = 'to';

    private string|array $tokens;

    private ?string $channel = null;

    public function __construct(array|string $tokens)
    {
        $this->tokens = $tokens;
    }

    public static function to($tokens): static
    {
        return new static($tokens);
    }

    public function channel($channel): static
    {
        $this->channel = $channel;

        return $this;
    }


    public function send($title, $message, array $data = []): PromiseInterface|Response|static|null
    {
        $params = [
            'priority' => 'high',
            'data' => $data,
            'notification' => [
                'content_available' => true,
                'body' => $message,
                'title' => $title,
                'sound' => 'default',
            ],
            $this->getSendTypeKey() => $this->tokens,
        ];
        if ($this->channel) {
            $params['notification']['channel_id'] = $this->channel;
            $params['notification']['android_channel_id'] = $this->channel;
        }

        try
        {
            return static::sendRequest($params);
        }
        catch (Throwable $e)
        {
            report($e);

            return $this;
        }
    }

    public static function sendRequest($params): PromiseInterface|Response
    {
        $response = Http::withoutVerifying()
            ->withToken(config('app.fcm_token'))
            ->post('https://fcm.googleapis.com/fcm/send', $params);

        $tokens = (array)($params[static::BULK_CLIENT_KEY] ?? $params[static::SINGLE_CLIENT_KEY]);

        $invalidTokens = [];

        foreach ($tokens as $key => $token) {

            if(in_array($response->json("results.$key.error"), ['NotRegistered', 'InvalidRegistration'])) {
                $invalidTokens[] = $token;
            }
        }

        //if token is invalid, remove it from database
        if (!empty($invalidTokens)) {

        }

        return $response;
    }

    private function getSendTypeKey(): string
    {
        return is_array($this->tokens) ? self::BULK_CLIENT_KEY : self::SINGLE_CLIENT_KEY;
    }
}
