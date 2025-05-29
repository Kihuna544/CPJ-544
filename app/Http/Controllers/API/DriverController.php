<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $driver = Driver::with('trips', 't2bTrips', 'b2tTrips', 'specialTrips')
                ->latest()
                ->paginate($perPage);

        return response()->json($driver);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
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
        $validated['created_by'] = auth()->id();
        $driver = Driver::create($validated);

        return response()->json($driver->load('trips', 't2bTrips', 'b2tTrips', 'specialTrips'), 201);
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

        $validated['updated_by'] = auth()->id();
        $driver->update($validated);

        return response()->json($driver->load('trips', 't2bTrips', 'b2tTrips', 'specialTrips'), 200);
    }

    
    public function show(Driver $driver)
    {
        return response()->json($driver->load('trips', 't2bTrips', 'b2tTrips', 'specialTrips'));
    }


    public function destroy(Driver $driver)
    {
        $driver->delete();
        
        return response()->json
        ([
            'message' => 'Driver deleted',
             'driver' => $driver->load('trips', 't2bTrips', 'b2tTrips', 'specialTrips')
        ]);
    }
}
