<?php

namespace App\Notifications;


class OrderAcceptedNotification extends OrderNotification
{
    protected string $channel = 'order-accepted';

    public function getTitle(): string
    {
        return 'Order Accepted';
    }

    public function getMessage(): string
    {
        return 'Your order has been accepted by a driver';
    }
}
