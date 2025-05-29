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
            'notes' => '' // should be validated
        ]);

        $validated['created_by'] = auth()->id();
        $expense = Expense::create($validated);

        return response()->json($expense->load('trip'), 201);
    }


    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate
        ([
            'expense_date' => 'required|date',
            'trip_id' => 'required|exists:trips,id',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'notes' => '' // should be validated
        ]);

        $validated['updated_by'] = auth()->id();
        $expense->update($validated);

        return response()->json($expense->load('trip'), 200);
    }


    public function show(Expense $expense)
    {
        return response()->json($expense->load('trip'));
    }


    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response()->json
        ([
            'message' => 'Expese successfully deleted',
            'expense' => $expense->load('trip')
        ]);
    }
}