<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DriverController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\TemporaryClientController;
use App\Http\Controllers\API\T2bTripClientController;
use App\Http\Controllers\API\T2bTripController;
use App\Http\Contollers\API\T2bClientItemController;
use App\Http\Controllers\API\B2tTripController;



Route::apiResource('/drivers', DriverController::class);
Route::apiResource('/clients', ClientController::class);
Route::apiResource('/temporaryClients', TemporaryClientController::class);
Route::apiResource('/t2bTrip', T2bTripController::class);
Route::apiResource('/t2bTripClients', T2bTripClientController::class);
Route::apiResource('/b2tTrip', B2tTripController::class);
Route::post('/b2t-trips/{b2tTrip}/refresh-totals', [B2tTripController::class, 'refreshTotals']);
