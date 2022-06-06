<?php

use App\Http\Controllers\Carrier\CarrierController;
use App\Http\Controllers\Port\PortController;
use App\Http\Controllers\V2\RatesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api']], function () {
    Route::get('port', [PortController::class,'getPort']);
    Route::get('carrier/json', [CarrierController::class, 'getJsonCarrier']);
    Route::get('carrier/xml', [CarrierController::class, 'getXmlCarrier']);

    Route::get('quote/rates/{state1?}/{state2?}/{count?}', RatesController::class);
});

