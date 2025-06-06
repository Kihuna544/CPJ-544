<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        
        $client = Client::with('b2tClients')
                ->latest()
                ->paginate($perPage);
        
        return response()->json
        ([
            'message' => 'success',
            'client' => $client
        ]);
        
    }

    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'client_name' => 'required|string',
            'phone' => 'required|string|unique:clients,phone',
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'profile_photo_camera' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $photoPath = null;

        if ($request->hasFile('profile_photo'))
        {
            $photoPath = $request->file('profile_photo')->store('clients', 'public');
        }

        elseif($request->hasFile('profile_photo_camera')) {
            $photoPath = $request->file('profile_photo_camera')->store('clients', 'public');
        }

        if ($photoPath)
        {
            $validated['profile_photo'] = $photoPath;
        }

        $validated['created_by'] = auth()->id();
        $client = Client::create($validated);

        return response()->json
        ([
            'message' => 'Client created successfully',
            'client' => $client->load('b2tClients')
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $validated = $request->validate
        ([
            'client_name' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|unique:clients,phone,'. $id,
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'profile_photo_camera' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $photoPath = null;

        if($request->hasFile('profile_photo'))
        {
            if($client->profile_photo)
            {
                \Storage::disk('public')->delete($client->profile_photo);
            }

            $photoPath = $request->file('profile_photo')->store('clients', 'public');
        }

        elseif($request->hasFile('profile_photo_camera'))
        {
            if($client->profile_photo)
            {
                \Storage::disk('public')->delete($client->profile_photo);
            }

            $photoPath = $request->file('profile_photo_camera')->store('clients', 'public');
        }

        if($photoPath)
        {
            $validated['profile_photo'] = $photoPath;
        }

        $validated['updated_by'] = auth()->id();
        $client->update($validated);

        return response()->json
        ([
            'message' => 'Client updated successfully',
            'client' => $client->load('b2tClients'
        )], 200);
    }

    
    public function show(Client $client)
    {
        return response()->json
        ([
            'message' => 'success',
            'client' => $client->load('b2tClients')
        ]);
    }


    public function destroy(Client $client)
    {
        $client->load('b2tClients');

        $client->deleted_by = auth()->id();
        $client->save();

        $deletedClient = $client;

        $client->delete();

        return response()->json
        ([
            'message' => 'Client deleted',
            'deletedClient' => $deletedClient
        ]);

    }


    public function trashed()
    {
        $trashedClient = Client::onlyTrashed()
                        ->with('b2tClients')
                        ->paginate($request->query('per_page', 10))
                        ->get();
        return response()->json
        ([
            'message' => 'success',
            'trashedClient' => $trashedClient
        ]);
    }


    public function restore($id)
    {
        $trashedClient = Client::onlyTrashed()->findOrFail($id);
        $trashedClient->restore();

        return response()->json
        ([
            'message' => 'Client restored Successfully',
            'trashedClient' => $trashedClient->load('b2tClients')
        ], 200);
    }
}