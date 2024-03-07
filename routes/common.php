<?php

use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('messages')->group(function () {
    Route::get('{order}', [MessageController::class, 'index']);
    Route::post('{order}', [MessageController::class, 'store']);
});

Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index']);
    Route::post('register-device', [NotificationController::class, 'registerFcmToken']);
    Route::post('unregister-device', [NotificationController::class, 'unregisterFcmToken']);
});

Route::prefix('orders')->group( function () {
    Route::get('/list/{status}', [OrderController::class, 'index']);
    Route::get('/{order}', [OrderController::class, 'show']);
    Route::put('/{order}/accept', [OrderController::class, 'accept']);
    Route::put('/{order}/cancel', [OrderController::class, 'cancel']);
    Route::put('/{order}/finish', [OrderController::class, 'finish']);
});
