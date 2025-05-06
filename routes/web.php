<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DriverController;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/drivers', [DriverController::class, 'index']);



require __DIR__.'/auth.php';
