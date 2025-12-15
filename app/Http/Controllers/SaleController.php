<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cart = session()->get('cart', []);
        return view('sales.index', compact('products', 'cart'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity
            ];
        }

        session()->put('cart', $cart);
        return redirect('/ventas');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect('/ventas');
    }

    public function checkout()
{
    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect('/ventas');
    }

    $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    $iva = $subtotal * 0.16;
    $total = $subtotal + $iva;

    $sale = Sale::create([
        'user_id' => auth()->id(),
        'subtotal' => $subtotal,
        'iva' => $iva,
        'total' => $total
    ]);

    foreach ($cart as $productId => $item) {
        SaleDetail::create([
            'sale_id' => $sale->id,
            'product_id' => $productId,
            'quantity' => $item['quantity'],
            'price' => $item['price']
        ]);

        Product::where('id', $productId)
            ->decrement('stock', $item['quantity']);
    }

    session()->forget('cart');

    return redirect('/ventas')->with('ticket_id', $sale->id);

}
    public function ticket($id)
{
    $sale = Sale::with('details.product')->findOrFail($id);
     return view('sales.ticket', [
        'sale' => $sale,
        'isPdf' => false
    ]);
}



public function ticketPdf($id)
{
    $sale = Sale::with('details.product')->findOrFail($id);

    $pdf = Pdf::loadView('sales.ticket', [
    'sale' => $sale,
    'isPdf' => true
]);


    return $pdf->download('ticket_venta_' . $sale->id . '.pdf');
}



}


