<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;

Route::get('/', function (){ return redirect(app()->getLocale()); });

Route::get('/rules', [HomeController::class, 'rules'])->name('rules');
Route::get('/docs/delete-data', [HomeController::class, 'deletePolicy'])->name('deletePolicy');


Route::prefix('{locale}')->where(['locale' => '[a-zA-Z]{2}'])->middleware('setLocale')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');

});
