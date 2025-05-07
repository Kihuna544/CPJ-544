<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DriverController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\TemporaryClientController;



Route::apiResource('/drivers', DriverController::class);
Route::apiResource('/clients', ClientController::class);
Route::apiResource('/temporaryClient', TemporaryClientController::class);