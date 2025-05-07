<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use  Illuminate\Http\Request;

class ClientController extends Controller {

    public function index() {
        
        return Client::all();
    }

    public function store(Request $request) {

        $validated = $request->validate ([
            'client_name' => 'required|string',
            'phone' => 'required|string|unique:drivers, phone',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profile_photo_camera' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;

        if($request->hasFile('profile_photo'))
        {
            $photoPath = $request->file('profile_photo')->store('drivers', 'public');
        }

        elseif($request->hasFIle('profile_photo_camera'))
        {
            $photoPath = $request->file('profile_photo_camera')->store('drivers', 'public');
        }

        if($photoPath) 
        {
            $validated['profile_photo'] = $photoPath;
        }

        $drivers = Driver::create($validated);
        return response()->json($client, 201);
    }
    
    public function show($id)
    {
        return Client::findOrFail($id);
    }  

    public function destroy($id) 
    {
        Client::findOrFail($id)->delete();
        return response()->with->json(['message' => 'Client deleted']);
    }

}