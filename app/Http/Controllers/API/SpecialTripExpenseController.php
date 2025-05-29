<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SpecialTripExpense;
use Illuminate\Http\Request;


class SpecialTripExpenseController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $specialTripExpense = SpecialTripExpense::with('specialTrip')
                            ->latest()
                            ->paginate($perPage);

        return response()->json($specialTripExpense);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'expense_date' => 'required|date',
            'special_trip_id' => 'required|exists:special_trips,id',
            'catogory' => 'required|strig|max:255',
            'amount' => 'required|numeric|min:0',
            'notes' => '',
        ]);

        $validated['created_by'] = auth()->id();
        $specialTripExpense = SpecialTripExpense::create($validated);

        return response()->json($specialTripExpense->load('specialTrip'), 201);
    }


    public function update(Request $request, SpecialTripExpense $specialTripExpense)
    {
        $validated = $request->validate
        ([
            'expense_date' => 'required|date',
            'special_trip_id' => 'required|exists:special_trips,id',
            'catogory' => 'required|strig|max:255',
            'amount' => 'required|numeric|min:0',
            'notes' => '',
        ]);

        $validated['updated_by'] = auth()->id();
        $specialTripExpense->create($validated);

        return response()->json($specialTripExpense->load('specialTrip'), 201);
    }


    public function show(SpecialTripExpense $specialTripExpense)
    {
        return response()->json($specialTripExpense->load('specialTrip'));
    }


    public function destroy(SpecialTripExpense $specialTripExpense)
    {
        $specialTripExpense->delete();

        return response()->json
        ([
            'message' => 'Expense deleted successfully',
            'specialTripExpense' => $specialTripExpense->load('speacialTrip')
        ]);
    }
}