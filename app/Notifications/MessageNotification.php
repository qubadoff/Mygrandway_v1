<?php

namespace App\Notifications;

use App\Models\Customer;
use App\Models\Driver;
use App\Models\Message;
use App\Support\Notification\Channels\FcmChannel;
use App\Support\Push;
use Illuminate\Notifications\Notification;

class MessageNotification extends Notification
{
    public function __construct(private readonly Message $message)
    {
        $this->message->loadMissing([
            'from:id,full_name',
            'to:id,full_name',
        ]);
    }

    public function via(Customer|Driver $notifiable): array
    {
        return [
            FcmChannel::class
        ];
    }

    public function toFcm(Customer|Driver $notifiable): void
    {
        $notifiable->routeNotificationForFcm() && Push::to($notifiable->routeNotificationForFcm())
            ->channel(Message::CHANNEL)
            ->send('New Message', $this->message->body, [
                ...$this->message->toArray(),
                'is_sender' => false
            ]);
    }
}
