<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable',
            'location' => 'nullable',
            'email' => 'nullable|email',
            'bussiness_name' => 'nullable',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    // In ClientController.php

public function getPaymentStatus($clientId)
{
    $client = Client::findOrFail($clientId);

    $lastPayment = $client->payments()->latest()->first(); // assuming you have a payments relationship
    $unpaidAmount = $lastPayment ? $lastPayment->amount - $lastPayment->paid_amount : 0;
    $newDeliveryAmount = 1000; // This would depend on your logic

    return response()->json([
        'paid' => $lastPayment && $lastPayment->paid_amount == $lastPayment->amount,
        'last_payment_amount' => $lastPayment ? $lastPayment->amount : 0,
        'last_payment_date' => $lastPayment ? $lastPayment->created_at->toDateString() : 'N/A',
        'unpaid_amount' => $unpaidAmount,
        'new_delivery_amount' => $newDeliveryAmount,
    ]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }
    
        //
    

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
    public function destroy(string $id)
    {
        //
    }
}
