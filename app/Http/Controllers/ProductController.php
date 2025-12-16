<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'stock' => 'required|integer',
            'price' => 'required|numeric'
        ]);

        Product::create($request->all());

        return redirect()->back();
    }

    public function edit(Product $product)
{
    return view('products.edit', compact('product'));
}

public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ]);

    $product->update($request->only('name', 'price', 'stock'));

    return redirect()->route('inventario')
        ->with('success', 'Producto actualizado correctamente');
}

public function destroy(Product $product)
{
    $product->delete();

    return redirect()->route('inventario')
        ->with('success', 'Producto eliminado correctamente');

}
}

