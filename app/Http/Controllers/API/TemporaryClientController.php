<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemporaryClient;  

class TemporaryClientController extends Controller
{

    public function index()
    {
    return TemporaryClient::all();        
    }
 

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string',
            'phone' => 'required|string|unique:temporary_clients, phone',
        ]);

    $temporaryClient = TemporaryClient::create($validated);
    return response()->json($temporaryClient , 201);   
    }


    public function update(Request $request, string $id)
    {
        $temporaryClient = TemporaryClient::findOrFail($id);

        $validated = $request->validate
        ([
            'client_name' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|unique:temporary_clients,phone,'. $id,
        ]);

        $temporaryClient->update($validated);
        return response()->json($temporaryClient, 200);
    }


    public function show($id)
    {
        return TemporaryClient::findOrFail($id);
    }

     
    public function destroy($id)
    {
        TemporaryClient::findOrFail($id)->delete();
        return response()->json(['message' => 'Client deleted']);
    }
}
