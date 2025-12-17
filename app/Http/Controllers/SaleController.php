<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function checkout(Request $request)
{
    $product = Product::findOrFail($request->product_id);
    
    $subtotal = $product->price * $request->quantity;
    $iva = $subtotal * 0.16;
    $total = $subtotal + $iva;

    $sale = Sale::create([
        'user_id' => auth()->id(),
        'subtotal' => $subtotal,
        'iva' => $iva,
        'total' => $total
    ]);

    SaleDetail::create([
        'sale_id' => $sale->id,
        'product_id' => $product->id,
        'quantity' => $request->quantity,
        'price' => $product->price
    ]);

    $product->decrement('stock', $request->quantity);

    return redirect()->route('ventas.create')->with('ticket_id', $sale->id);
}

    public function index()
    {
        $sales = Sale::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('sales.index', compact('sales'));
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
