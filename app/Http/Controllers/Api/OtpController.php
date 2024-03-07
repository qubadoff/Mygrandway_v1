<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\OtpRequest;
use App\Support\Api;
use App\Support\Contracts\CurrentUser;

class OtpController extends ApiController
{
    public function send(CurrentUser $user): Api
    {
        if ($user->hasVerifiedPhone()) {
            return api()->ok()->setMessage('Account already verified !');
        }

        if ($user->hasPendingPhoneVerificationNotification()) {
            return api()->ok()->setMessage('OTP already sent !');
        }

        $otpRequest = $user->sendPhoneVerificationNotification();

        return api([
            'verification_id' => $otpRequest->id,
        ])->ok()->setMessage('OTP sent successfully !');
    }

    public function verify(OtpRequest $request,CurrentUser $user): Api
    {
        if ($user->hasVerifiedPhone()) {
            return api()->ok()->setMessage('Account already verified !');
        }

        $user->verifyPhone($request->get('code'));

        return api()->ok()->setMessage('Account verified successfully !');
    }
}
