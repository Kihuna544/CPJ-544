<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\T2bClientItem;
use App\Http\Request;

class T2bClientItemController extends Controller
{

    public function index()
    {
        return T2bClientItem::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate
        ([

        ]);

        $t2bClientItem = T2bClientItem::create($validated);
        return response()->json($t2bClientItem, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate
        ([ 

        ]);

        $t2bClientItem->update($validated);
        return response()->json($t2bClientItem, 200);
    }


    public function show($id)
    {
        return T2bClientItem::findOrFail($id);
    }


    public function destroy($id)
    {
        T2bClientItem::findOrFail($id)->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
