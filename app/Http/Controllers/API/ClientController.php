<?php

use App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller{

    public function index()
    {
        return Client::all();
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

        $client = Client::create($validated);
        return response()->json($client, 201);
    }


    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $validated = $request->validate
        ([
            'clientt_name' => 'sometimes|required|string',
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
            if($client->profile_photo_camera)
            {
                \Storage::disk('public')->delete($client->profile_photo);
            }

            $photoPath = $request->file('profile_photo_camera')->store('clients', 'public');
        }

        if($photoPath)
        {
            $validated['profile_photo'] = $photoPath;
        }

        $client->update($validated);
        return response()->json($client, 200);
    }

    
    public function show($id)
    {
        return Client::findOrFail($id);
    }


    public function destroy($id)
    {
        Client::findOrFail($id)->delete();
        return response()->json(['message' => 'Client deleted']);

    }
}