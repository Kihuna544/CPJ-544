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
use App\Http\Controllers\API\PaymentTransactionController;
use App\Http\Controllers\API\SpecialTripClientController;
use App\Http\Controllers\API\SpecialTripClientItemController;
use App\Http\Controllers\API\SpecialTripController;
use App\Http\Controllers\API\SpecialTripExpenseController;
use App\Http\Controllers\API\T2bClientItemController;
use App\Http\Controllers\API\T2bTripClientController;
use App\Http\Controllers\API\T2bTripController;
use App\Http\Controllers\API\TemporaryClientController;
use App\Http\Controllers\API\TripController;



Route::apiResource('/b2tTripClients', B2tTripClientController::class);
Route::apiResource('/b2tTrips', B2tTripController::class);
Route::apiResource('/clients', ClientController::class);
Route::apiResource('/drivers', DriverController::class);
Route::apiResource('/expenses', ExpenseController::class);
Route::apiResource('/offDutyExpenses', OffDutyExpenseController::class);
Route::apiResource('/payments', PaymentController::class);
Route::apiResource('/paymentTransactions', PaymentTransactionController::class);
Route::apiResource('/specialTripClients', SpecialTripClientController::class);
Route::apiResource('/specialTripClientItems', SpecialTripClientItemController::class);
Route::apiResource('/specialTrips', SpecialTripController::class);
Route::apiResource('/specialTripExpenses', SpecialTripExpenseController::class);
Route::apiResource('/t2bTripClientItems', T2bClientItemController::class);
Route::apiResource('/t2bTripClients', T2bTripClientController::class);
Route::apiResource('/t2bTrips', T2bTripController::class);
Route::apiResource('/temporaryClients', TemporaryClientController::class);
Route::apiResource('/trips', TripController::class);

Route::post('/b2t-trips/{b2tTrip}/refresh-totals', [B2tTripController::class, 'refreshTotals']);
