<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Trip;
use App\Models\ClientParticipation;
use Illuminate\Http\Request;

class ClientParticipationController extends Controller
{
    public function index()
    {
        $participations = ClientParticipation::with('trip', 'client')->latest()->paginate(10);
        return view('participations.index', compact('participations'));
    }

    public function create()
    {
        $trips = Trip::all();
        $clients = Client::all();
        return view('participations.create', compact('trips', 'clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'client_id' => 'required|exists:clients,id',
            'crop_type' => 'nullable|string|max:100',
            'sacks_carried' => 'required|integer|min:1',
            'amount_to_pay' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        $balance = $request->amount_to_pay - $request->amount_paid;

        ClientParticipation::create([
            'trip_id' => $request->trip_id,
            'client_id' => $request->client_id,
            'crop_type' => $request->crop_type,
            'sacks_carried' => $request->sacks_carried,
            'amount_to_pay' => $request->amount_to_pay,
            'amount_paid' => $request->amount_paid,
            'balance' => $balance,
        ]);

        return redirect()->route('participations.index')->with('success', 'Client participation added.');
    }

    public function edit(ClientParticipation $participation)
    {
        $trips = Trip::all();
        $clients = Client::all();
        return view('participations.edit', compact('participation', 'trips', 'clients'));
    }

    public function update(Request $request, ClientParticipation $participation)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'client_id' => 'required|exists:clients,id',
            'crop_type' => 'nullable|string|max:100',
            'sacks_carried' => 'required|integer|min:1',
            'amount_to_pay' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        $balance = $request->amount_to_pay - $request->amount_paid;

        $participation->update([
            'trip_id' => $request->trip_id,
            'client_id' => $request->client_id,
            'crop_type' => $request->crop_type,
            'sacks_carried' => $request->sacks_carried,
            'amount_to_pay' => $request->amount_to_pay,
            'amount_paid' => $request->amount_paid,
            'balance' => $balance,
        ]);

        return redirect()->route('participations.index')->with('success', 'Participation updated.');
    }

    public function destroy(ClientParticipation $participation)
    {
        $participation->delete();
        return redirect()->route('participations.index')->with('success', 'Participation deleted.');
    }
        public function latestBalance(Client $client)
    {
        $last = $client->participations()->latest()->first();
        $balance = $last ? $last->balance : 0;

        return response()->json(['balance' => $balance]);
    }

}
