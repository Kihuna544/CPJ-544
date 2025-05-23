<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\T2bTripClient;
use Illuminate\Http\Request;

class T2bTripClientController extends Controller
{
    
    public function index()
    {
        return T2bTripClient::all();
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([

        ]);

        $t2bTripClient = T2bTripClient::create($validated);
        return response()->json($t2bTripClient, 201);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate
        ([

        ]);

        $t2bTripClient->update($validated);
        return response()->json($t2bTripClient, 200);
    }


    public function show($id)
    {
        return T2bTripClient::findOrFail($id);
    }


    public function delete($id)
    {
        T2bTripClient::findOrFail($id)->delete();

        return response()->json(['message' => 'Client deleted successfully']);
    }

}