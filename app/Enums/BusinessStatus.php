<?php

namespace App\Enums;

enum BusinessStatus : int
{
    case PENDING = 0;
    case APPROVED = 1;
    case REJECTED = 2;


    public static function getForNovaDisplay(): array
    {
        return [
            self::PENDING->value => 'Pending',
            self::APPROVED->value => 'Approved',
            self::REJECTED->value => 'Rejected',
        ];
    }
}
