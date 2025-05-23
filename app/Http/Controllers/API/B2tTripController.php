<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\B2tTrip;
use App\Http\Request;

class B2tTripController extends Controller
{

    public function index()
    {
        return B2tTrip::all();
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([

        ]);

        $b2tTrip = B2tTrip::create($validated);
        return response()->json($b2tTrip, 201);
    }


    public function update(Request $request, $id)
    {
            $validated = $request->validate
            ([
                
            ]);

            $b2tTrip->update($validated);
            return response()->json($b2tTrip, 200);
    }


    public function show($id)
    {
        return B2tTrip::findOrFail($id);
    }


    public function destroy($id)
    {
        B2tTrip::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}