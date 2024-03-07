<?php

namespace App\Components\Eloquent\Contracts;

use App\Models\OtpRequest;

interface MustVerifyPhone
{
    public function hasVerifiedPhone();

    /**
     * Mark the given user's phone as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified();

    /**
     * Send the phone verification notification.
     *
     * @return OtpRequest
     */
    public function sendPhoneVerificationNotification(): OtpRequest;

    /**
     * Get the phone address that should be used for verification.
     *
     * @return string
     */
    public function getPhoneForVerification();


    public function hasPendingPhoneVerificationNotification(): bool;

    public function getIsVerifiedAttribute(): bool;
}
