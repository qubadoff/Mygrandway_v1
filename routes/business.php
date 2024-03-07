<?php

use App\Http\Controllers\Business\BusinessAuthController;
use App\Http\Controllers\Business\BusinessController;
use Illuminate\Support\Facades\Route;

//Route::fallback(function () { return to_route('business.dashboard'); });

Route::prefix('business')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::get('/login', [BusinessAuthController::class, 'login'])
            ->name('business.login');
        Route::post('/login/post', [BusinessAuthController::class, 'loginPost'])
            ->name('business.loginPost');
    });

    Route::prefix('dashboard')->middleware('BusinessAuthDashboardMiddleware')->group(function () {

        //dashboard page
        Route::get('/dashboard', [BusinessController::class, 'dashboard'])->name('business.dashboard');

        //Driver info page
        Route::get('/driver/{id}', [BusinessController::class, 'driver'])->name('business.driver');


        //logout
        Route::get('/dashboard/logout', [BusinessController::class, 'logout'])->name('business.logout');

        //Settings Page
        Route::get('/dashboard/settings', [BusinessController::class, 'settings'])->name('business.settings');
    });
});

