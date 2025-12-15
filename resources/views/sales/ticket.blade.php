<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket</title>
    <style>
        body {
            font-family: monospace;
            background: #fff;
        }
        .ticket {
            width: 300px;
            margin: auto;
            border: 1px dashed #000;
            padding: 10px;
        }
        h2, h4 {
            text-align: center;
            margin: 5px 0;
        }
        table {
            width: 100%;
            font-size: 12px;
        }
        td {
            padding: 2px 0;
        }
        .total {
            border-top: 1px dashed #000;
            margin-top: 8px;
            padding-top: 5px;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="ticket">
    <h2>Tienda POS</h2>
    <h4>Ticket de venta</h4>

    <p>
        Fecha: {{ $sale->created_at->format('d/m/Y H:i') }} <br>
        Venta #: {{ $sale->id }}
    </p>

    <table>
        @foreach($sale->details as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>x{{ $item->quantity }}</td>
            <td align="right">
                ${{ number_format($item->price * $item->quantity, 2) }}
            </td>
        </tr>
        @endforeach
    </table>

    <div class="total">
        <p>Subtotal: ${{ number_format($sale->subtotal, 2) }}</p>
        <p>IVA (16%): ${{ number_format($sale->iva, 2) }}</p>
        <p><strong>Total: ${{ number_format($sale->total, 2) }}</strong></p>
    </div>

    <p class="center">
        ¡Gracias por su compra!
    </p>
</div>

@if(!$isPdf)
    <div class="center" style="margin-top:10px;">
        <a href="{{ route('ticket.pdf', $sale->id) }}" target="_blank">
            Descargar ticket
        </a>
    </div>
@endif


</body>
</html>
