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
    
    $temporaryClients = TemporaryClient::with('t2bClients', 'specialTripClients')
                    ->latest()
                    ->paginate($perPage);

    return response()->json
    ([
        'message' => 'Success',
        'temporaryClient' => $temporaryClients
    ]);
    }
 

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string',
            'phone' => 'required|string|unique:temporary_clients,phone',
        ]);

        $validated['created_by'] = auth()->id();
        $temporaryClient = TemporaryClient::create($validated);

        return response()->json
        ([
            'message' => 'Client created successfully',
            'temporaryClient' => $temporaryClient->load('t2bClients', 'specialTripClients') 
        ], 201);   
    }


    public function update(Request $request, TemporaryClient $temporaryClient)
    {
        $validated = $request->validate
        ([
            'client_name' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|unique:temporary_clients,phone,'. $temporaryClient->id,
        ]);
        $validated['updated_by'] = auth()->id();
        $temporaryClient->update($validated);

        return response()->json
        ([
            'message' => 'Client updated successfully',
            'temporaryClient' => $temporaryClient->load('t2bClients', 'specialTripClients')
        ], 200);
    }


    public function show(TemporaryClient $temporaryClient)
    {
        return response()->json
        ([
            'message' => 'Success',
            'temporaryClient' => $temporaryClient->load('t2bClients', 'specialTripClients')
        ]);
    }

     
    public function destroy(TemporaryClient $temporaryClient)
    {
        $temporaryClient->load('t2bClients', 'specialTripClients');

        $temporaryClient->deleted_by = auth()->id();
        $temporaryClient->save();

        $trashedClient = $temporaryClient;

         $temporaryClient->delete();

        return response()->json
        ([
            'message' => 'Client deleted',
            'temporaryClient' => $trashedClient->load('t2bClients', 'specialTripClients'),
        ]);
    }


    public function trashed()
    {
        $trashedClients = TemporaryClient::onlyTrashed()
                    ->with('t2bClients', 'specialTripClients')
                    ->paginate($request->query('per_page', 10))
                    ->get();

        return response()->json
        ([
            'message' => 'Success',
            'trashedClients' => $trashedClients
        ]);
    }


    public function restore($id)
    {
        $trashedClient = TemporaryClient::onlyTrashed()->findOrFail($id);
        $trashedClient->restore();

        return response()->json
        ([
            'message' => 'Client restored successfully',
            'trashedClient' => $trashedClient->load('t2bClients', 'specialTripClients')
        ],200);
    }
}
