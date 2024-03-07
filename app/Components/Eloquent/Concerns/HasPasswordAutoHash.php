<?php

namespace App\Components\Eloquent\Concerns;

use Illuminate\Support\Facades\Hash;

trait HasPasswordAutoHash
{
    public function setPasswordAttribute($value): void
    {
        if (Hash::needsRehash($value)) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }
}
