<?php

namespace App\Notifications;


class OrderCompletedNotification extends OrderNotification
{
    protected string $channel = 'order-completed';

    public function getTitle(): string
    {
        return 'Order Completed';
    }

    public function getMessage(): string
    {
        return 'Your order has been completed !';
    }
}
