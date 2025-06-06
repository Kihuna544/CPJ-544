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

        $specialTripExpenses = SpecialTripExpense::with('specialTrip')
                            ->latest()
                            ->paginate($perPage);

        return response()->json
        ([
            'message' => 'Success',
            'specialTripExpenses' => $specialTripExpenses

        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'expense_date' => 'required|date',
            'special_trip_id' => 'required|exists:special_trips,id',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'notes' => 'required|string|max:10000',
        ]);

        $validated['created_by'] = auth()->id();
        $specialTripExpense = SpecialTripExpense::create($validated);

        return response()->json
        ([
            'message' => 'Expense created successfully',
            'specialTripExpense' => $specialTripExpense->load('specialTrip')
        ], 201);
    }


    public function update(Request $request, SpecialTripExpense $specialTripExpense)
    {
        $validated = $request->validate
        ([
            'expense_date' => 'sometimes|required|date',
            'special_trip_id' => 'sometimes|required|exists:special_trips,id',
            'category' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric|min:0',
            'notes' => 'sometimes|required|string|max:10000',
        ]);

        $validated['updated_by'] = auth()->id();
        $specialTripExpense->update($validated);

        return response()->json
        ([
            'message' => 'Expense successfully updated',
            'specialTripExpense' => $specialTripExpense->load('specialTrip')
        ], 200);
    }


    public function show(SpecialTripExpense $specialTripExpense)
    {
        return response()->json
        ([
            'message' => 'Success',
            'specialTripExpense' => $specialTripExpense->load('specialTrip')
        ]);
    }


    public function destroy(SpecialTripExpense $specialTripExpense)
    {
        $specialTripExpense->load('specialTrip');

        $specialTripExpense->deleted_by = auth()->id();
        $specialTripExpense->save();

        $trashedExpense = $specialTripExpense;

        $specialTripExpense->delete();

        return response()->json
        ([
            'message' => 'Expense deleted successfully',
            'specialTripExpense' => $trashedExpense
        ]);
    }


    public function trashed()
    {
        $trashedExpenses = SpecialTripExpense::onlyTrashed()
                        ->with('specialTrip')
                        ->get();

        return response()->json
        ([
            'message' => 'Success',
            'trashedExpenses' => $trashedExpenses
        ]);
    }


    public function restore($id)
    {
        $trashedExpense = SpecialTripExpense::onlyTrashed()->findOrFail($id);
        $trashedExpense->restore();

        return response()->json
        ([
            'message' => 'Expense restored successfully',
            'trashedExpense' => $trashedExpense->load('specialTrip')
        ],200);
    }
}