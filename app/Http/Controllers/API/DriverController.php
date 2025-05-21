<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        return Driver::all();
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string|unique:drivers,phone',
            'license_number' => 'required|string|unique:drivers,license_number',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profile_photo_camera' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


    $photoPath = null;

    if($request->hasFile('profile_photo')) {
        $photoPath = $request->file('profile_photo')->store('drivers', 'public');
    }

    elseif ($request->hasFile('profile_photo_camera')) {
        $photoPath = $request->file('profile_photo_camera')->store('drivers', 'public');
    }

    if ($photoPath) {
        $validated['profile_photo'] = $photoPath;
    }

        $driver = Driver::create($validated);
        return response()->json($driver, 201);
    }


    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|unique:drivers,phone,' . $id,
            'license_number' => 'sometimes|required|string|unique:drivers,license_number,' . $id,
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'profile_photo_camera' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        if ($request->hasFile('profile_photo'))
        {
            if($driver->profile_photo)
            {
                \Storage::disk('public')->delete($driver->profile_photo);
            }

            $photoPath = $request->file('profile_photo')->store('drivers', 'public');
        }

        elseif($request->hasFile('profile_photo_camera'))
        {
            if($driver->profile_photo)
            {
                \Storage::disk('public')->delete($driver->profile_photo);
            }

            $photoPath = $request->file('profile_photo_camera')->store('drivers', 'public');
        }

        if($photoPath)
        {
            $validated['profile_photo'] = $photoPath;
        }

        $driver->update($validated);
        return response()->json($driver, 200);
    }

    
    public function show($id)
    {
        return Driver::findOrFail($id);
    }


    public function destroy($id)
    {
        Driver::findOrFail($id)->delete();
        return response()->json(['message' => 'Driver deleted']);
    }
}
