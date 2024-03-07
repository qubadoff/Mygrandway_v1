<?php


use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\Drivers\DriverController;
use App\Http\Controllers\Api\PasswordResetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Support\SupportController;
use App\Http\Controllers\Api\CurrencyTypeController;

Route::get('/truck-types', [DriverController::class, 'truckTypes']);
Route::get('/currency-types', [CurrencyTypeController::class, 'currencyType']);

Route::get('/countries', [CountryController::class, 'countries']);
Route::get('/countries/{country}/cities', [CountryController::class, 'cities']);

Route::prefix('password')->controller(PasswordResetController::class)->group(function (): void {
    Route::post('forgot', 'forgot');
    Route::post('check', 'check');
    Route::post('reset', 'reset');
});


Route::get('/support-data', [SupportController::class, 'index']);
