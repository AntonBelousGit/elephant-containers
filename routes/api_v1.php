<?php

use App\Http\Controllers\Carrier\CarrierController;
use App\Http\Controllers\Port\PortController;
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
    Route::get('port', PortController::class);
    Route::get('carrier/json', [CarrierController::class, 'getJsonCarrier']);
    Route::get('carrier/xml', [CarrierController::class, 'getXmlCarrier']);
});
