<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Sale::count();
        $totalIncome = Sale::sum('total');

        $todaySales = Sale::whereDate('created_at', today())->count();
        $todayIncome = Sale::whereDate('created_at', today())->sum('total');

        $lowStockProducts = Product::where('stock', '<=', 5)->get();

        return view('dashboard', compact(
            'totalSales',
            'totalIncome',
            'todaySales',
            'todayIncome',
            'lowStockProducts'
        ));
    }
}
