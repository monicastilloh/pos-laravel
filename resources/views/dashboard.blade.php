@extends('layouts.app')

@section('content')

<h2>📊 Dashboard</h2>

<div class="dashboard-grid">

    <div class="card">
        <h3>Total de ventas</h3>
        <p class="big-number">{{ $totalSales }}</p>
    </div>

    <div class="card">
        <h3>Ingresos totales</h3>
        <p class="big-number">${{ number_format($totalIncome, 2) }}</p>
    </div>

    <div class="card">
        <h3>Ventas hoy</h3>
        <p class="big-number">{{ $todaySales }}</p>
    </div>

    <div class="card">
        <h3>Ingresos hoy</h3>
        <p class="big-number">${{ number_format($todayIncome, 2) }}</p>
    </div>

</div>

@if($lowStockProducts->count())
<div class="card">
    <h3>⚠️ Productos con bajo stock</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lowStockProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td class="danger">{{ $product->stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
