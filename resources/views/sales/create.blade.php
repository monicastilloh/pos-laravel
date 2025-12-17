@extends('layouts.app')

@section('content')

<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        display: none; /* Se cambia a flex con JS o la condición de abajo */
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 400px;
        position: relative;
    }
    .ticket-frame {
        width: 100%;
        height: 450px;
        border: 1px solid #eee;
    }
    .modal-close {
        position: absolute;
        top: 10px;
        right: 15px;
        cursor: pointer;
        font-size: 20px;
    }
</style>

<h2>🛒 Punto de Venta</h2>

@if(session('ticket_id'))
    <div id="ticketModal" class="modal-overlay" style="display: flex;">
        <div class="modal-content">
            <span class="modal-close" onclick="document.getElementById('ticketModal').style.display='none'">&times;</span>
            <h3 style="text-align: center;">Venta Exitosa</h3>
            
            <iframe src="{{ url('/ticket/' . session('ticket_id')) }}" class="ticket-frame"></iframe>
            
        </div>
    </div>
@endif

<div class="grid-container" style="display: grid; grid-template-columns: 1fr 350px; gap: 20px;">
    <div class="card-venta">
        <h3>Selección de Producto</h3>
        <form id="sale-form" method="POST" action="/ventas/confirmar">
            @csrf
            <div class="form-grid">
                <div>
                    <label>Producto</label>
                    <select class="input" name="product_id" id="product_id" required onchange="updateSummary()">
                        <option value="" data-price="0">Seleccione un producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }} (${{ number_format($product->price, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Cantidad</label>
                    <input type="number" autocomplete="off" name="quantity" id="quantity" min="1" value="1" required oninput="updateSummary()" class="input" placeholder="Ingrese la cantidad">
                </div>
            </div>
        </form>
    </div>

    <div class="card-venta">
        <h3>Resumen de Venta</h3>
        <hr>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span>Subtotal:</span>
            <strong id="res-subtotal">$0.00</strong>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span>IVA (16%):</span>
            <strong id="res-iva">$0.00</strong>
        </div>
        <hr>
        <div style="display: flex; justify-content: space-between; font-size: 1.2em; color: #2c3e50;">
            <span>TOTAL:</span>
            <strong id="res-total">$0.00</strong>
        </div>
        <button type="submit" form="sale-form" class="btn-primary" style="width: 100%; margin-top: 20px;">
            Finalizar Venta
        </button>
    </div>
</div>

<script>
function updateSummary() {
    const select = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const price = parseFloat(select.options[select.selectedIndex].getAttribute('data-price')) || 0;
    const quantity = parseInt(quantityInput.value) || 0;

    const subtotal = price * quantity;
    const iva = subtotal * 0.16;
    const total = subtotal + iva;

    document.getElementById('res-subtotal').innerText = `$${subtotal.toFixed(2)}`;
    document.getElementById('res-iva').innerText = `$${iva.toFixed(2)}`;
    document.getElementById('res-total').innerText = `$${total.toFixed(2)}`;
}
</script>
@endsection