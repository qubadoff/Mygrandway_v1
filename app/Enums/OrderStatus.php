<?php

namespace App\Enums;

enum OrderStatus : string
{
    case Pending = 'pending';
    case Chatting = 'chatting';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Canceled = 'canceled';

    public static function getActiveList(): array
    {
        return [
            self::Chatting->value,
            self::Accepted->value,
            self::InProgress->value,
        ];
    }

    public function isCancelable() : bool
    {
        return in_array($this->value, [
            self::InProgress->value,
            self::Chatting->value,
        ]);
    }

    public static function toSelectOptions(): array
    {
        return [
            self::Pending->value => 'Pending',
            self::Chatting->value => 'Chatting',
            self::Rejected->value => 'Rejected',
            self::InProgress->value => 'In Progress',
            self::Completed->value => 'Completed',
            self::Canceled->value => 'Canceled',
        ];
    }


    public function isPending(): bool
    {
        return $this->value === self::Pending->value;
    }

    public function inChatting(): bool
    {
        return $this->value === self::Chatting->value;
    }

    public function inProgress(): bool
    {
        return $this->value === self::InProgress->value;
    }
}
