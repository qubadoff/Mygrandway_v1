<?php

namespace App\Notifications;


class NewOrderNotification extends OrderNotification
{
    protected string $channel = 'new-order';

    public function getTitle(): string
    {
        return 'New Order';
    }

    public function getMessage(): string
    {
        return 'You have a new order !';
    }
}
