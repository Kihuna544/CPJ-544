<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OffDutyExpense;
use Illuminate\Http\Request;

class OffDutyExpenseController extends Controller
{

    public function index(Request $request)
    {
        $offDutyExpense = OffDutyExpense::with('/')
                        ->OrderByDesc('expense_date')
                        ->paginate(10);
                    
        return response()->json($offDutyExpense);
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

        return response()->json($offDutyExpense);
    }


    public function update(Request $request, OffDutyExpense $offDutyExpense)
    {
        $validated = $request->validate
        ([
            'expense_date' => 'sometimes|required|date',
            'category' => 'sometimes|required|string|max:100',
            'amount' => 'sometimes|required|numeric|mi:0',
            'notes' => 'sometimes|required|string|max:10000'
        ]);

        $validated['updated_by'] = auth()->id();
        $offDutyExpense->update($validated);

        return response()->json($offDutyExpense);
    }


    public function show(Request $request)
    {
        return response()->json($offDutyExpense);
    }


    public function destroy(Request $request)
    {
        $offDutyExpense->unlink;

        return response()->json
        ([
            'message' => 'Expense deleted',
            'offDutyExpense' => $offDutyExpense
        ]);
    }
}