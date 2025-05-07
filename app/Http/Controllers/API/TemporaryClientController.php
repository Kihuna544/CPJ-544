<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemporaryClientController extends Controller
{

    public function index()
    {
    return TemporaryClient::all();        
    }
 

    public function store(Request $request)
    {
        $validated = $request->validated([
            'client_name' => 'required|string',
            'phone' => 'required|string|unique:TemporaryClient, phone',
        ]);

    $temporaryClient = TemporaryClient::create($validated);
    return response()->json($temporaryClient , 201);   
    }


    public function show($id)
    {
        return TemporaryClient::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        TemporaryClient::findOrFail($id)->delete();
        return response()->with()->json(['message' => 'Client deleted']);
    }
}
