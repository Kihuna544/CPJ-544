<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TripController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('trips', TripController::class);
Route::resource('clients', ClientController::class);
Route::resource('drivers', DriverController::class);
Route::resource('payments', PaymentController::class);
Route::resource('expenses', ExpenseController::class);
Route::resource('journeys', JourneyController::class);
Route::resource('client-participations', ClientParticipationController::class);


require __DIR__.'/auth.php';
