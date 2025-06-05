<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OffDutyExpense;
use Illuminate\Http\Request;

class OffDutyExpenseController extends Controller
{

    public function index(Request $request)
    {
        $offDutyExpense = OffDutyExpense::orderByDesc('expense_date')
                        ->paginate(10);
                    
        return response()->json
        ([
            'message' => 'success',
            'offDutyExpense' => $offDutyExpense
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'expense_date' => 'required|date',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'notes' => 'required|string|max:10000',
        ]);

        $validated['created_by'] = auth()->id();
        $offDutyExpense = OffDutyExpense::create($validated);

        return response()->json
        ([
            'message' => 'Expense added successfully',
            'offDutyExpense' => $offDutyExpense
        ]);
    }


    public function update(Request $request, OffDutyExpense $offDutyExpense)
    {
        $validated = $request->validate
        ([
            'expense_date' => 'sometimes|required|date',
            'category' => 'sometimes|required|string|max:100',
            'amount' => 'sometimes|required|numeric|min:0',
            'notes' => 'sometimes|required|string|max:10000'
        ]);

        $validated['updated_by'] = auth()->id();
        $offDutyExpense->update($validated);

        return response()->json
        ([
            'message' => 'Expense updated successfully',
            'offDutyExpense' => $offDutyExpense
        ], 200);
    }


    public function show(OffDutyExpense $offDutyExpense)
    {
        return response()->json
        ([
            'message' => 'success',
            'offDutyExpense' => $offDutyExpense
        ]);
    }


    public function destroy(OffDutyExpense $offDutyExpense)
    {
        $offDutyExpense->deleted_by = auth()->id();
        $offDutyExpense->save();

        $deletedExpense = $offDutyExpense;

        $offDutyExpense->delete();

        return response()->json
        ([
            'message' => 'Expense deleted',
            'offDutyExpense' => $deletedExpense
        ]);
    }


    public function trashed()
    {
        $offDutyExpense = OffDutyExpense::onlyTrashed()->get();

        return response()->json
        ([
            'message' => 'success',
            'offDutyExpense' => $offDutyExpense
        ]);
    }


    public function restore($id)
    {
        $offDutyExpense = OffDutyExpense::onlyTrashed()->findOrFail($id);
        $offDutyExpense->restore();

        return response()->json
        ([
            'message' => 'Expense restored successfully',
            'offDutyExpense' => $offDutyExpense
        ], 200);
    }
}