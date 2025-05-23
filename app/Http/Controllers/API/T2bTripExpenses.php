<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\T2bExpenses;
use App\Http\Request;

class T2bTripExpensesController extends Controller
{

    public function index()
    {
        return T2bExpense::all;
    }

    public function store(Request $request)
    {

        $validated = $request->validate
        ([

        ]);

        $t2bExpenses = T2bExpense::create($validated);
        return response()->json($t2bExpenses, 201);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate
        ([

        ]);

        $t2bExpenses->update($validated);
        return response()->json($t2bExpenses, 200);
    }


    public function show($id)
    {
        return T2bExpense::findOrFail($id);
    }


    public function destroy($id)
    {
        T2bExpense::findOrFail($id)->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}