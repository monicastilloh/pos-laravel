<style>
    @media print {
            .no-print { display: none !important; }
            .ticket { border: none; margin: 0; width: 100%; }
            body { background: #fff; }

        }
        .ticket {
            width: 300px;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #000;
            font-family: monospace;
            font-size: 12px;
        }
        .ticket h2, .ticket h3 {
            text-align: center;
            margin: 5px 0;
        }
        .ticket table {
            width: 100%;
            border-collapse: collapse;
        }
        .ticket th, .ticket td {
            padding: 5px 0;
        }
        .ticket p {
            margin: 5px 0;
            text-align: center;
        }
        .ticket .total {
            font-weight: bold;
            font-size: 16px;
            text-align: right;
        }
        .ticket .separator {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
       .center-no-print {
            margin-top: 15px;
            text-align: center;

        }
        .center-no-print a, .center-no-print button {
            margin: 0 10px;
            font-size: 16px;
            padding: 5px 10px;
            cursor: pointer;
            border: none;
            background: #ebebebff;
            border-radius: 4px;
            text-decoration: none;
            color: #000;
            box-shadow: #000000ff 2px 2px 5px;
            font-family: Arial, Helvetica, sans-serif;

         }
        .center-no-print a:hover, .center-no-print button:hover {
            background: #0c7988ff;
        }

              

        
        
    </style>
</head>
<body>

<div class="ticket">
    <h2>Tienda POS</h2>
    <br>
    <h3>Ticket de Venta #{{ $sale->id }}</h3>
    <br>
    <p>Fecha: {{ $sale->created_at->format('d/m/Y H:i') }}</p><br><br>
    <hr>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align: left; border-bottom: 1px solid #000;">Producto</th>
                <th style="text-align: right; border-bottom: 1px solid #000;">Cantidad</th>
                <th style="text-align: right; border-bottom: 1px solid #000;">Precio</th>
                <th style="text-align: right; border-bottom: 1px solid #000;">Subtotal</th>
            </tr>
        </thead>
        
        <tbody>
            
            @foreach($sale->details as $detail)
            <tr>

                <td style="padding: 5px 0;">{{ $detail->product->name }}</td>
                <td style="text-align: right; padding: 5px 0;">{{ $detail->quantity }}</td>
                <td style="text-align: right; padding: 5px 0;">${{ number_format($detail->price, 2) }}</td>
                <td style="text-align: right; padding: 5px 0;">${{ number_format($detail->price * $detail->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table><br>
    <hr><br>
    <div style="display: flex; justify-content: space-between; margin-top: 10px;">
        <strong>Subtotal:</strong>
        <span>${{ number_format($sale->subtotal, 2) }}</span>

    </div>
    <div style="display: flex; justify-content: space-between; margin-top: 5px;">
        <strong>IVA (16%):</strong>
        <span>${{ number_format($sale->subtotal * 0.16, 2) }}</span>
    </div>
    <div style="display: flex; justify-content: space-between; margin-top:
    5px; font-size: 1.2em;">
            <strong>TOTAL:</strong>
            <span>${{ number_format($sale->total, 2) }}</span>
    </div><br><br><br>
    <p>¡Gracias por su compra!</p>
</div>
<br>
<br>


@if(!$isPdf)
    <div class="center-no-print" >
        <button onclick="window.print();" style="cursor:pointer; padding: 5px 10px;">
            🖨️ Imprimir
        </button>
        
        <a href="{{ route('ticket.pdf', $sale->id) }}" >
            📄 Descargar PDF
        </a>
    </div>
@endif