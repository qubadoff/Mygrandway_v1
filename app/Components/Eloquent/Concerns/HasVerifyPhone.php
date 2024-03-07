<?php

namespace App\Components\Eloquent\Concerns;

use App\Exceptions\OtpException;
use App\Models\OtpRequest;
use App\Services\SmsService;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait HasVerifyPhone
 * @package App\Components\Eloquent\Concerns
 * @property ?string $phone_verified_at
 * @property ?string $phone
 */
trait HasVerifyPhone
{
    public function hasVerifiedPhone(): bool
    {
        return (bool)$this->phone_verified_at;
    }

    public function markPhoneAsVerified(): void
    {
        $this->phone_verified_at = now();

        $this->saveQuietly();
    }

    public function hasPendingPhoneVerificationNotification(): bool
    {
        return $this->otpRequests()
            ->where('expires_at', '>', now())
            ->exists();
    }

    public function sendPhoneVerificationNotification(): OtpRequest
    {
        $token = random_int(1000, 9999);

        $this->otpRequests()->delete();

        /** @var OtpRequest $otpRequest */
        $otpRequest = $this->otpRequests()->createQuietly([
            'phone' => $this->getPhoneForVerification(),
            'otp' => $token,
            'expires_at' => now()->addMinutes(5),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        SmsService::createFromContainer()->send($this->phone, "Your verification code is: $token");

        return $otpRequest;
    }

    public function otpRequests(): MorphMany
    {
        return $this->morphMany(OtpRequest::class, 'modelable');
    }

    public function getPhoneForVerification(): ?string
    {
        return $this->phone;
    }


    /**
     * @throws OtpException
     */
    public function verifyPhone(string $token): bool
    {
        /** @var OtpRequest $otpRequest */
        $otpRequest = $this->otpRequests()->latest()->first();

        if (!$otpRequest) {
            throw new OtpException('You have not requested a verification code');
        }

        if($otpRequest->wasAttemptLimitReached()) {
            $otpRequest->delete();
            throw new OtpException('Too many attempts');
        }

        if ($otpRequest->isExpired()) {
            $otpRequest->delete();
            throw new OtpException('Token expired');
        }


        if ($otpRequest->otp !== $token) {
            $otpRequest->increment('attempts');
            throw new OtpException('Invalid token');
        }

        $this->markPhoneAsVerified();

        $otpRequest->delete();

        return true;
    }

    public function getIsVerifiedAttribute() : bool
    {
        return $this->hasVerifiedPhone();
    }
}
