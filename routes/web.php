<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ExpenseController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('trips', TripController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('drivers', DriverController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('expenses', ExpenseController::class);

});



require __DIR__.'/auth.php';
