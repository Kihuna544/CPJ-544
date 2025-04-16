<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\ClientParticipationController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[DashboardController::class, 'index'] );
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');   


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
Route::resource('journeys', JourneyController   ::class);
Route::resource('client-participations', ClientParticipationController::class);
Route::get('/clients/{client}/latest-balance', [ParticipationController::class, 'latestBalance']);
Route::get('/clients/{client}/profile', [ClientController::class, 'profile'])->name('clients.profile');


require __DIR__.'/auth.php';
