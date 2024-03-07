<?php


use App\Http\Controllers\Api\Drivers\DriverAuthController;
use App\Http\Controllers\Api\Drivers\DriverController;
use App\Http\Controllers\Api\OtpController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [DriverAuthController::class, 'login']);
    Route::post('register', [DriverAuthController::class, 'register']);
    Route::get('user', [DriverAuthController::class, 'user']);
    Route::post('logout', [DriverAuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('otp')->group(function () {
        Route::post('send', [OtpController::class, 'send']);
        Route::post('verify', [OtpController::class, 'verify']);
    });

    Route::post('user/update', [DriverController::class, 'update']);
    Route::post('account/delete', [DriverController::class, 'delete']);

    Route::middleware('verified')->group(function () {
        Route::post('change-location', [DriverController::class, 'changeLocation']);

        require __DIR__ . '/common.php';
    });

});
