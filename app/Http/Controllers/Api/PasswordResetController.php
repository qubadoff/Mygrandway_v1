<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PasswordResetRequest;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\PasswordReset;
use App\Support\Api;
use Exception;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:10,1');
    }

    public function forgot(PasswordResetRequest $request): Api
    {
        try {
            /** @var Customer|Driver $user */
            $user = PasswordReset::findUserByPhone($request->post('phone'));

            if (! $user) {
                return api()->setCode(422)->setMessage('The given data was invalid.')->setError([
                    'phone' => ['The phone field is invalid.'],
                ]);
            }

            $user->sendPasswordResetNotification(random_int(100000, 999999));

            return api([
                'phone' => $user->phone,
            ])->setMessage('Password reset code has been sent to your phone');
        } catch (Exception $e) {
            return api()
                ->setMessage('Something went wrong.')
                ->setCode(500)
                ->e($e);
        }
    }

    public function check(PasswordResetRequest $request): Api
    {
        /** @var Customer|Driver $user */
        $user = PasswordReset::findUserByPhone($request->post('phone'));

        if (! $user) {
            return api()->setCode(422)->setMessage('The phone number is not registered.');
        }

        $passwordReset = $user->password_reset;

        if (! $passwordReset) {
            return api()->ok(false)->setCode(422)->setMessage('The password reset code is invalid.');
        }

        if ($passwordReset->isExpired()) {
            $passwordReset->delete();

            return api()->ok(false)->setCode(422)->setMessage('The password reset code has expired.');
        }

        if ($passwordReset->isReachedLimit()) {
            $passwordReset->delete();

            return api()->ok(false)->setCode(422)->setMessage('The password reset attempts has been reached.');
        }

        if ($passwordReset->token !== $request->post('token')) {
            $passwordReset->incrementAttempts();

            return api()->ok(false)->setCode(422)->setMessage('The password reset code is invalid.');
        }

        return api([
            'phone' => $user->phone,
            'reset_key' => $passwordReset->verification_key,
        ])
            ->setMessage('Password reset code is valid.');
    }

    public function reset(PasswordResetRequest $request): Api
    {
        DB::beginTransaction();

        try {
            $passwordReset = PasswordReset::findByVerifyKey($request->post('reset_key'));

            if (! $passwordReset) {
                return api()->setCode(422)->setMessage('You did not request a password reset.');
            }

            ($user = $passwordReset->user)->forceFill([
                'password' => $request->post('password'),
            ])->saveQuietly();

            $passwordReset->delete();

            DB::commit();

            return api(['phone' => $user->getPhoneForPasswordReset()])->setMessage('Password has been reset.');
        } catch (Exception $e) {
            DB::rollBack();

            return api()->ok(false)->setCode(500)->setMessage('An error occurred while resetting password.');
        }
    }

}
