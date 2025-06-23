<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LandingController;
use App\Http\Controllers\Api\CurrencyController;

Route::get('/currency/rates', [CurrencyController::class, 'getRates']);
Route::get('/landing', [LandingController::class, 'index']);