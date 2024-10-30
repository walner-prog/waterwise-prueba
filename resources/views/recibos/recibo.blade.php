<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Ingreso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .recibo-container {
            width: 400px;
            border: 2px solid black;
            padding: 20px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 22px;
            margin: 0;
        }
        .header h2 {
            font-size: 16px;
            margin: 0;
            font-weight: normal;
        }
        .header p {
            margin: 5px 0;
        }
        .recibo-body {
            margin-bottom: 20px;
        }
        .recibo-body table {
            width: 100%;
            border-collapse: collapse;
        }
        .recibo-body table td {
            padding: 8px;
            font-size: 14px;
        }
        .recibo-body table td input {
            width: 100%;
            border: none;
            font-size: 14px;
        }
        .footer {
            text-align: right;
            font-size: 14px;
        }
        .firma {
            margin-top: 40px;
            text-align: left;
        }
        .cancelado {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            color: red;
        }
    </style>
</head>
<body>

<div class="recibo-container">
    <div class="header">
        <h1>COMITÉ DE AGUA POTABLE Y<br>SANEAMIENTO  CAPS WATERWISE</h1>
        <h2>Recibo de Factura Nº 
            <span>
                @foreach($facturasDetalles as $detalle)
                    {{ $detalle['numero_factura'] }}@if (!$loop->last), @endif
                @endforeach
            </span>
        </h2>
        
        <p>RUC: R0815400424372</p>
        <p>Valor: <strong>C$ {{ number_format($totalPagado, 2) }}</strong></p>
    </div>

    <div class="recibo-body">
        <table>
            <tr>
                <td>Recibimos de:</td>
                <td><input type="text" value="{{ $cliente->primer_nombre }} {{ $cliente->segundo_nombre }} {{ $cliente->primer_apellido }} {{ $cliente->segundo_apellido }}"></td>
            </tr>
            <tr>
                <td>La cantidad de:</td>
                <td><input type="text" value="C$ {{ number_format($totalPagado, 2) }}"></td>
            </tr>
            <tr>
                <td>Lecturas:</td>
                <td>
                    <input type="text" value="@foreach($facturasDetalles as $detalle){{ number_format($detalle['lectura_anterior'], 0) }} - {{ number_format($detalle['lectura_actual'], 0) }}@if (!$loop->last), @endif @endforeach">
                </td>
            </tr>
            <tr>
                <td>Consumo de agua:</td>
                <td>
                    <input type="text" value="@foreach($facturasDetalles as $detalle){{ number_format($detalle['consumo'], 0) }} m³@if (!$loop->last), @endif @endforeach">
                </td>
            </tr>
            <tr>
                <td>En concepto de:</td>
                <td><input type="text" value="Pago de agua"></td>
            </tr>
            <tr>
                <td>Mes cancelado:</td>
                <td>
                    <input type="text" value="@foreach($facturasDetalles as $detalle){{ $detalle['mes_leido'] }}@if (!$loop->last), @endif @endforeach">
                </td>
            </tr>
            <tr>
                <td>Fecha:</td>
                <td><input type="text" value="{{ \Carbon\Carbon::parse($fecha_pago)->format('d/m/Y') }}"></td>
            </tr>
        </table>
    </div>

    <div class="cancelado">
        <p>CANCELADO</p>
    </div>

    <div class="firma">
        <p>Entregué conforme: <strong>NOMBRE Y APELLIDO</strong></p>
    </div>
</div>

</body>
</html>
