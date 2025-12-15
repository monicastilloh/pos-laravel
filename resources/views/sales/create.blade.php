@extends('layouts.app')

@section('content')

<h2>🛒 Ventas</h2>

@if(session('ticket_id'))
    <script>
        window.open("{{ url('/ticket/' . session('ticket_id')) }}", "_blank");
    </script>
@endif


<div class="card">
    <h3>Agregar producto</h3>

    <form method="POST" action="/carrito/agregar" class="form-grid">
        @csrf

        <div>
            <label>Producto</label>
            <select name="product_id" required>
                <option value="">Seleccione</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (${{ number_format($product->price,2) }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Cantidad</label>
            <input type="number" name="quantity" min="1" required>
        </div>

        <button class="btn-primary">Agregar</button>
    </form>
</div>

<div class="card">
    <h3>Carrito</h3>

    @if(empty($cart))
        <p>No hay productos en el carrito.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>${{ number_format($item['price'],2) }}</td>
                        <td>${{ number_format($subtotal,2) }}</td>
                        <td>
                            <form method="POST" action="/carrito/eliminar/{{ $id }}">
                                @csrf
                                <button class="logout">X</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Total: ${{ number_format($total,2) }}</h3>

        <form method="POST" action="/ventas/confirmar">
            @csrf
            <button class="btn-primary">Confirmar venta</button>
        </form>
    @endif
</div>

@endsection
