<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $trip = Trip::with('parentTrip', 'childTrip')
            ->latest()
            ->paginate();

        return response()->json($trip);
    }
}