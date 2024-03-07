<?php

namespace App\Http\Controllers\Api\Drivers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Driver\AuthRequest;
use App\Models\Driver;
use App\Support\Api;
use App\Support\Contracts\DriverUser;
use Illuminate\Support\Facades\DB;
use Throwable;

class DriverAuthController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['user', 'logout']);
    }

    public function register(AuthRequest $request)
    {
        DB::beginTransaction();

        try {

            $driver = Driver::createOrFail($request->validated());

            $driver->uploadMediaFromRequest($request);

            $driver->sendPhoneVerificationNotification();

            DB::commit();

            return api([
                'user' => $driver,
                'type' => 'driver',
                'access_token' => $driver->createToken('driver')->plainTextToken,
                'token_type' => 'Bearer',
                'expires_in' => config('sanctum.expiration')
            ])->setMessage('Registered successfully');

        } catch (Throwable $e) {

            DB::rollBack();

            return api()->internalServerError()->e($e)->setMessage('Something went wrong !');
        }
    }

    public function login(AuthRequest $request): Api
    {
        /** @var Driver $user */
        if (!$user = Driver::attempt($request->only(['phone', 'password']))) {
            return api()->unprocessableEntity()->setMessage('Invalid Credentials !');
        }

        return api([
            'user' => $user,
            'type' => 'driver',
            'access_token' => $user->createToken('driver')->plainTextToken,
            'token_type' => 'Bearer',
            'expires_in' => config('sanctum.expiration')
        ])->setMessage('Logged in successfully');
    }

    public function user(DriverUser $user): Api
    {
        return api($user->loadMissing(['media', 'truck_type','routes']));
    }


    public function logout(DriverUser $user): Api
    {
        $user->currentAccessToken()->delete();

        return api()->ok()->setMessage('Logged out successfully');
    }


}
