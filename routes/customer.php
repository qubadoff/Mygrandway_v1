<?php

use App\Http\Controllers\Api\Customer\CustomerAuthController;
use App\Http\Controllers\Api\Customer\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OtpController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('login', [CustomerAuthController::class, 'login']);
    Route::post('register', [CustomerAuthController::class, 'register']);
    Route::post('logout', [CustomerAuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('auth/user', [CustomerAuthController::class, 'user']);
    Route::post('user/update', [CustomerController::class, 'update']);
    Route::post('account/delete', [CustomerController::class, 'delete']);

    Route::prefix('otp')->group(function () {
        Route::post('send', [OtpController::class, 'send']);
        Route::post('verify', [OtpController::class, 'verify']);
    })->middleware('throttle:5,1');

    Route::middleware('verified')->group(function () {

        require __DIR__ . '/common.php';

        Route::prefix('GetDriverLocation')->group( function () {
            Route::get('/GetDriverLocation', [CustomerController::class, 'getDriverLocation']);
        });


        Route::prefix('orders')->group(function () {
            Route::post('/', [OrderController::class, 'store']);
            Route::delete('/{id}', [OrderController::class, 'delete']);
            Route::post('/looking-for-drivers/{id}', [OrderController::class, 'lookingForDrivers']);
        });
    });

});
