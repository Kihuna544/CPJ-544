<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $expense = Expense::with('trip')
                ->latest()
                ->paginate($perPage);

    return response()->json($expense);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'expense_date' => 'required|date',
            'trip_id' => 'required|exists:trips,id',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:10000'
        ]);

        $validated['created_by'] = auth()->id();
        $expense = Expense::create($validated);

        return response()->json($expense->load('trip'), 201);
    }


    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate
        ([
            'expense_date' => 'sometimes|required|date',
            'trip_id' => 'sometimes|required|exists:trips,id',
            'category' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric|min:0',
            'notes' => 'sometimes|required|string|max:10000'
        ]);

        $validated['updated_by'] = auth()->id();
        $expense->update($validated);

        return response()->json
        ([
            'message' => 'Expense updated successfully',
            'expense' => $expense->load('trip')
        ], 200);
    }


    public function show(Expense $expense)
    {
        return response()->json($expense->load('trip'));
    }


    public function destroy(Expense $expense)
    {
        $expense->load('trip');

        $expense->deleted_by = auth()->id();
        $expense->save();

        $deletedExpense = $expense;

        $expense->delete();

        return response()->json
        ([
            'message' => 'Expense successfully deleted',
            'deletedExpense' => $deletedExpense
        ]);
    }


    public function trashed()
    {
        $trashedExpense = Expense::onlyTrashed()
                        ->with('trip')
                        ->get();
        
        return response()->json($trashedExpense);
    }


    public function restore($id)
    {
        $trashedExpense = Expense::onlyTrashed()->findOrFail($id);
        $trashedExpense->restore();

        return response()->json
        ([
            'message' => 'Expense restored successfully',
            'trashedExpense' => $trashedExpense->load('trip')
        ], 200);
    }
}