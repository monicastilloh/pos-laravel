@extends('layouts.app')

@section('content')



<h2>📄 Historial de Ventas</h2>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Subtotal</th>
                <th>IVA</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $sale->user->name ?? '—' }}</td>
                    <td>${{ number_format($sale->subtotal, 2) }}</td>
                    <td>${{ number_format($sale->iva, 2) }}</td>
                    <td class="total">
                        ${{ number_format($sale->total, 2) }}
                    </td>
                    <td>
                        <button type="button" class="btn-link" onclick="openTicket({{ $sale->id }})" style="background:none; border:none; color:blue; cursor:pointer; text-decoration:underline;">
                            Ver ticket
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No hay ventas registradas</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="ticketModal" class="modal-overlay">
    <div class="modal-content">
        <span class="modal-close" onclick="closeTicket()">&times;</span>
        <h3 style="margin-top:0">Detalle de Venta</h3>
        <iframe id="ticketFrame" src="" class="ticket-frame"></iframe>
        <div style="margin-top: 15px; text-align: right;">
            <button onclick="closeTicket()" class="btn-secondary">Cerrar</button>
        </div>
    </div>
</div>

<script>
    function openTicket(saleId) {
        const modal = document.getElementById('ticketModal');
        const frame = document.getElementById('ticketFrame');
        
        // Construimos la URL usando el ID de la venta
        frame.src = `/ticket/${saleId}`;
        
        // Mostramos el modal
        modal.style.display = 'flex';
    }

    function closeTicket() {
        const modal = document.getElementById('ticketModal');
        const frame = document.getElementById('ticketFrame');
        
        // Ocultamos y limpiamos el iframe para que no se quede el ticket anterior
        modal.style.display = 'none';
        frame.src = '';
    }

    // Cerrar modal si se hace clic fuera del contenido blanco
    window.onclick = function(event) {
        const modal = document.getElementById('ticketModal');
        if (event.target == modal) {
            closeTicket();
        }
    }
</script>

@endsection