<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SpecailTripExpense;
use Illuminate\Http\Request;


class SpecailTripExpenseController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $specailTripExpense = SpecialTripExpense::with('specialTrip')
                            ->latest()
                            ->paginate($perPage);

        return response()->json($specailTripExpense);
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
        $specailTripExpense = SpecialTripExpense::create($validated);

        return response()->json($specailTripExpense->load('specialTrip'), 201);
    }


    public function update(Request $request, SpecialTripExpense $specailTripExpense)
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
        $specailTripExpense->create($validated);

        return response()->json($specailTripExpense->load('specialTrip'), 201);
    }


    public function show(SpecialTripExpense $specailTripExpense)
    {
        return response()->json($specailTripExpense->load('specialTrip'));
    }


    public function destroy(SpecialTripExpense $specailTripExpense)
    {
        $specailTripExpense->delete();

        return response()->json
        ([
            'message' => 'Expense deleted successfully',
            'specialTripExpense' => $specailTripExpense->load('speacialTrip')
        ]);
    }
}