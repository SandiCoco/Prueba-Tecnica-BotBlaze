<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryLog;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index()
    {
        return response()->json(InventoryLog::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'cantidad' => 'required',
            'operacion' => 'required'
        ]);


        if($request->operacion == 'entrada'){
            $product = Product::find($request->product_id);
            $product->cantidad += $request->cantidad;
            $product->save();
        }
        if($request->operacion == 'salida'){
            $product = Product::find($request->product_id);
            $product->cantidad -= $request->cantidad;
            $product->save();
        }

        $inventory = InventoryLog::create($request->all());
        return response()->json($inventory, 201);
    }

    public function show(InventoryLog $inventory)
    {
        return response()->json($inventory);
    }

    public function update(Request $request, InventoryLog $inventory)
    {
        $request->validate([
            'product_id' => 'required',
            'cantidad' => 'required',
            'operacion' => 'required'
        ]);
        $inventory->update($request->all());
        return response()->json($inventory, 200);
    }

    public function destroy(InventoryLog $inventory)
    {
        $inventory->delete();
        return response()->json(null, 204);
    }
}
