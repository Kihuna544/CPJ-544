<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index() {
            $drivers = Driver::all();
            return view('drivers.index', compact('drivers'));
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('drivers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'license_number' => 'nullable',
        ]);

        Driver::create($request->only(['name', 'phone', 'license_number'])); // ✅ CORRECT

        return redirect()->route('drivers.index'->with('sucess', 'Driver added succesfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        $request->delete();
        return redirect()->route('drivers.index')->with('success', 'Driver deleted succesfully!');
    }
}
