<?php

namespace App\Notifications;

use App\Models\Customer;
use App\Models\Driver;
use App\Models\Order;
use App\Support\Notification\Channels\DatabaseOrderChannel;
use App\Support\Notification\Channels\FcmChannel;
use App\Support\Push;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

abstract class OrderNotification extends Notification
{
    use Queueable;

    protected string $channel = 'order';

    public function __construct(public Order $order)
    {
    }

    public function toFcm(Driver|Customer $notifiable): void
    {
        $notifiable->routeNotificationForFcm() && Push::to($notifiable->routeNotificationForFcm())
            ->channel($this->channel)
            ->send($this->getTitle(), $this->getMessage(), $this->toArray($notifiable));
    }


    public function via(object $notifiable): array
    {
        return [
            FcmChannel::class,
            DatabaseOrderChannel::class,
        ];
    }

    abstract public function getTitle(): string;

    abstract public function getMessage(): string;


    public function bulk(array|Collection $drivers)
    {
        if(!empty($drivers)) {

            $tokens = $drivers[0] instanceof Driver ? $drivers->pluck('fcm_token')->toArray() : $drivers;

            Push::to($tokens)
                ->channel($this->channel)
                ->send(
                    $this->getTitle(),
                    $this->getMessage(),
                    $this->toArray($drivers)
                );
        }

    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $data = $this->order->toArray();

        $data['title']   = $this->getTitle();
        $data['message'] = $this->getMessage();

        return $data;
    }
}
