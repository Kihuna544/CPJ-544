<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DriverController;

// Optional test route
Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

// Your actual Driver routes
Route::apiResource('/drivers', DriverController::class);
