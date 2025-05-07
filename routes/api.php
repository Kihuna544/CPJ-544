<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DriverController;
use App\Http\Contrllers\API\ClientController;



Route::apiResource('/drivers', DriverController::class);
Route::apiResource('/clients', ClientController::class);