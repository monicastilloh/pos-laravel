@extends('layouts.app')

@section('content')

<h2>📦 Inventario</h2>

<div class="card">
    <h3>Agregar producto</h3>

    <form method="POST" action="/inventario" class="form-grid">
        @csrf

        <div>
            <label>Nombre</label>
            <input type="text" name="name" placeholder="Ej. Pan dulce" required>
        </div>

        <div>
            <label>Stock</label>
            <input type="number" name="stock" placeholder="Ej. 50" required>
        </div>

        <div>
            <label>Precio</label>
            <input type="number" step="0.01" name="price" placeholder="Ej. 10.00" required>
        </div>

        <button type="submit" class="btn-primary">Guardar</button>
    </form>
</div>

<div class="card">
    <h3>Productos registrados</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Stock</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ $p->stock }}</td>
                <td>${{ number_format($p->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
