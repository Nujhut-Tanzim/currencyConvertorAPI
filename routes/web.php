<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyConvertorController;
use App\Http\Middleware\VerifyKeyMiddileWare;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/getAPI",[CurrencyConvertorController::class,"getAPI"])->middleware([VerifyKeyMiddileWare::class]);
Route::get("/ratesAPI",[CurrencyConvertorController::class,"getAllRate"])->middleware([VerifyKeyMiddileWare::class]);
Route::get("/currencyConvertor",[CurrencyConvertorController::class,"CurrencyConversion"])->middleware([VerifyKeyMiddileWare::class]);