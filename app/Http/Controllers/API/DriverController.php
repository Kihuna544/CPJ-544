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

        return response()->json
        ([
            'message' => 'success',
            'driver' => $driver
        ]);
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

        return response()->json
        ([
            'message' => 'Driver created successfully',
            'driver' => $driver->load('trips', 't2bTrips', 'b2tTrips', 'specialTrips')
        ], 201);
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

        $photoPath = null;

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

        return response()->json
        ([
            'message' => 'Driver updated successfully',
            'driver' =>$driver->load('trips', 't2bTrips', 'b2tTrips', 'specialTrips')
        ], 200);
    }

    
    public function show(Driver $driver)
    {
        return response()->json
        ([
            'message' => 'success',
            'driver' => $driver->load('trips', 't2bTrips', 'b2tTrips', 'specialTrips')
        ]);
    }


    public function destroy(Driver $driver)
    {
        $driver->load('trips', 't2bTrips', 'b2tTrips', 'specialTrips');

        $driver->deleted_by = auth()->id();
        $driver->save();

        $deletedDriver = $driver;

        $driver->delete();
        
        return response()->json
        ([
            'message' => 'Driver deleted',
            'deletedDriver' => $deletedDriver
        ]);
    }


    public function trashed()
    {
        $trashedDriver = Driver::onlyTrashed()
                    ->with('trips', 't2bTrips', 'b2tTrips', 'specialTrips')
                    ->paginate($request->query('per_page', 10))
                    ->get();

        return response()->json
        ([
            'message' => 'success',
            'driver' => $trashedDriver
        ]);
    }


    public function restore($id)
    {
        $trashedDriver = Driver::onlyTrashed()->findOrFail($id);
        $trashedDriver->restore();
        
        return response()->json
        ([
            'message' => 'Driver restored successfully',
            'trashedDriver' => $trashedDriver->load('trips', 't2bTrips', 'b2tTrips', 'specialTrips')
        ], 200);
    }
}
