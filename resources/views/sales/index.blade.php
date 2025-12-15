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
                        <a href="{{ route('ticket.show', $sale->id) }}" target="_blank" class="btn-link">
                            Ver ticket
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        No hay ventas registradas
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
