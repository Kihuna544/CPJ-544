<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\B2tTripClientController;
use App\Http\Controllers\API\B2tTripController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\DriverController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\OffDutyExpenseController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\PaymmentTransactionController;
use App\Http\Controllers\API\SpecialTripClientConroller;
use App\Http\Controllers\API\SpecialTripClientItemConroller;
use App\Http\Controllers\API\SpecialTripController;
use App\Http\Controllers\API\SpecialTripExpenseController;
use App\Http\Controllers\API\T2bTripClientItemController;
use App\Http\Controllers\API\T2bTripClientController;
use App\Http\Controllers\API\T2bTripController;
use App\Http\Controllers\API\TemporaryClientController;
use App\Http\Controllers\API\TripController;



Route::apiResource('/b2tTripClients', B2tTripClientController::class);
Route::apiResource('/b2tTrips', B2tTripController::class);
Route::apiResource('/clients', ClientController::class);
Route::apiResource('/drivers', DriverController::class);
Route::apiResource('/expenses', ExpenseController::class);
Route::apiResource('/offDutyExpenses', OffDutyExpenseController::classs);
Route::apiResource('/payments', PaymentController::class);
Route::apiResource('/paymentTransactions', PaymmentTransactionController::class);
Route::apiResource('/specialTripClients', SpecialTripClientConroller::class);
Route::apiResource('/specialTripClientItems', SpecialTripClientItemConroller::class);
Route::apiResource('/specialTrips', SpecialTripController::class);
Route::apiResource('/specialTripExpenses', specialTripExpenses::class);
Route::apiResource('/t2bTripClientItems', T2bTripClientItemController::class);
Route::apiResource('/t2bTripClients', T2bTripClientController::class);
Route::apiResource('/t2bTrips', T2bTripController::class);
Route::apiResource('/temporaryClients', TemporaryClientController::class);
ROute::apiResource('/trips', TripController::class);

Route::post('/b2t-trips/{b2tTrip}/refresh-totals', [B2tTripController::class, 'refreshTotals']);
