<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
            'cantidad' => 'required'
        ]);
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
            'cantidad' => 'required'
        ]);
        $product->update($request->all());
        return response()->json($product, 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }

    public function search($name)
    {
        return response()->json(Product::where('nombre', 'like', '%'.$name.'%')->get());
        // postman request example: GET http://localhost:8000/api/productos/buscar/Producto
    }
}
