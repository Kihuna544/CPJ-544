<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemporaryClient;  

class TemporaryClientController extends Controller
{

    public function index(Request $request)
    {
    $perPage = $request->query('per_page', 10);
    
    $temporaryClient = TemporaryClient::with('t2bClients', 'specialTripClients')
                    ->latest()
                    ->paginate($perPage);

    return response()->json($temporaryClient);
    }
 

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string',
            'phone' => 'required|string|unique:temporary_clients, phone',
        ]);

        $validated['created_by'] = auth()->id();
        $temporaryClient = TemporaryClient::create($validated);

    return response()->json($temporaryClient->load('t2bClients', 'specialTripClients') , 201);   
    }


    public function update(Request $request, TemporaryClient $temporaryClient)
    {
        $validated = $request->validate
        ([
            'client_name' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|unique:temporary_clients,phone,'. $id,
        ]);
        $validated['updated_by'] = auth()->id();
        $temporaryClient->update($validated);

        return response()->json($temporaryClient->load('t2bClients', 'specialTripClients'), 200);
    }


    public function show(TemporaryClient $temporaryClient)
    {
        return response()->json($temporaryClient->load('t2bClients', 'specialTripClients'));
    }

     
    public function destroy(TemporaryClient $temporaryClient)
    {
        $temporaryClient->delete();

        return response()->json
        ([
            'message' => 'Client deleted',
            'temporartClient' => $temporaryClient->load('t2bClients', 'specialTripClients'),
        ]);
    }
}
