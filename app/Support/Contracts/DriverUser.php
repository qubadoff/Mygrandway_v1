<?php

namespace App\Support\Contracts;


use App\Models\Driver;

/**
 * @mixin Driver
 */
interface DriverUser
{
    public function hasActiveOrder(): bool;
}
