<?php

namespace App\Notifications;

use App\Models\Customer;
use App\Models\Driver;
use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(protected string $token)
    {
        //
    }


    public function via(Driver|Customer $notifiable): array
    {
        return tap([], function (array &$via) use ($notifiable) {
            $this->toPhone($notifiable);
        });
    }


    public function toPhone(Driver|Customer $notifiable): void
    {
        SmsService::createFromContainer()->send(
            $notifiable->getPhoneForPasswordReset(),
            'Your reset password code is: ' . $this->token
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
