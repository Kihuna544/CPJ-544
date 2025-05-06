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
            'profile_photo' => 'nullable|string',
        ]);

        $driver = Driver::create($validated);
        return response()->json($driver, 201);
    }

    public function show($id)
    {
        return Driver::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|unique:drivers,phone,' . $id,
            'license_number' => 'sometimes|required|string|unique:drivers,license_number,' . $id,
            'profile_photo' => 'nullable|string',
        ]);

        $driver->update($validated);
        return response()->json($driver);
    }

    public function destroy($id)
    {
        Driver::findOrFail($id)->delete();
        return response()->json(['message' => 'Driver deleted']);
    }
}
