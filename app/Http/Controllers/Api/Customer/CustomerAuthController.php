<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Customer\CustomerAuthRequest;
use App\Models\Customer;
use App\Support\Api;
use App\Support\Contracts\CustomerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CustomerAuthController extends ApiController
{
    public function register(CustomerAuthRequest $request)
    {
        DB::beginTransaction();

        try {

            $customer = Customer::createOrFail($request->validated());

            $customer->sendPhoneVerificationNotification();

            DB::commit();

            return api([
                'user' => $customer,
                'type' => 'customer',
                'access_token' => $customer->createToken('customer')->plainTextToken,
                'token_type' => 'Bearer',
                'expires_in' => config('sanctum.expiration')
            ])->setMessage('Registered successfully');

        } catch (Throwable $e) {

            DB::rollBack();

            return api()->internalServerError()->e($e)->setMessage('Something went wrong !');
        }
    }

    public function user(CustomerUser $user): Api
    {
        return api($user)->setMessage('Logged user fetched successfully !');
    }

    public function login(CustomerAuthRequest $request): Api
    {
        if (!$user = Customer::attempt($request->only(['phone', 'password']))) {
            return api()->unprocessableEntity()->setMessage('Invalid Credentials !');
        }

        return api()->ok()->setData([
            'user' => $user,
            'type' => 'customer',
            'access_token' => $user->createToken('customer')->plainTextToken,
            'token_type' => 'Bearer',
            'expires_in' => config('sanctum.expiration')
        ])->setMessage('Logged in successfully !');
    }

    public function logout(Request $request,CustomerUser $user): Api
    {
        $user->currentAccessToken()->delete();

        return api()->ok()->setMessage('Logged out successfully !');
    }
}
