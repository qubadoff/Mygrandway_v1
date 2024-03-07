<?php

namespace App\Components\Eloquent\Concerns;

use App\Models\PasswordReset;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Relations\MorphOne;


/**
 * @property ?PasswordReset $password_reset
 */
trait CanResetPassword
{
    public function getPhoneForPasswordReset(): string
    {
        return $this->phone;
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->password_reset()->delete();

        /** @var PasswordReset $passwordReset */
        $passwordReset = $this->password_reset()->create([
            'token' => $token,
        ]);

        $this->notify(new ResetPasswordNotification($passwordReset->token));
    }

    public function password_reset(): MorphOne
    {
        return $this->morphOne(PasswordReset::class, 'user');
    }
}
