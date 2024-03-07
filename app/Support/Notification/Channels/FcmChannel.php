<?php

namespace App\Support\Notification\Channels;

use App\Models\Customer;
use App\Models\Driver;

class FcmChannel
{
    public function send(Customer|Driver $notifiable, $notification): void
    {
        $notification->toFcm($notifiable);
    }
}
