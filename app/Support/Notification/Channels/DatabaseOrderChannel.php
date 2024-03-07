<?php

namespace App\Support\Notification\Channels;

use App\Models\Customer;
use App\Models\Driver;
use Illuminate\Support\Str;

class DatabaseOrderChannel
{
    public function send(Customer|Driver $notifiable, $notification): void
    {
        $notifiable->notifications()->create([
            'id' => Str::orderedUuid(),
            'data' => $notification->toArray($notifiable),
            'read_at' => null,
            'order_id' => $notification->order->id ?? null,
        ]);
    }
}
