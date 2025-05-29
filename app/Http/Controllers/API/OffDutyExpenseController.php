<?php 

namespace App\Http\Contollers\API;

use App\Http\Controllers\Controller;
use App\Http\Models;
use Illuminate\Http\Request;

class OffDutyExpenseController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $offDutyExpense = OffDutyExpense::class
                        ->OrderbyDesc('expense_date')
                        ->paginate($perPage);

        return response()->json($offDutyExpense);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'expense_date' => 'required|date',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'notes' => '', // should be validated
        ]);

        $validated['created_by'] = auth()->id();
        $offDutyExpense = OffDutyExpense::create($validated);


        return response()->json($offDutyExpense);
    }


    public function update(Request $request, OffDutyExpense $offDutyExpense)
    {
        $validated = $request->validate
        ([
            'expense_date' => 'required|date',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'notes' => '', // should be validated
        ]);

        $validated['updated_by'] = auth()->id();
        $offDutyExpense->create($validated);


        return response()->json($offDutyExpense);
    }


    public function show(OffDutyExpense $offDutyExpense)
    {
        return response()->json($offDutyExpense);
    }


    public function destroy(OffDutyExpense $offDutyExpense)
    {
        $offDutyExpense->delete();

        return response()->json
        ([
            'message' => 'Expense deleted successfully',
            'offDutyExpense' => $offDutyExpense
        ]);
    }
}