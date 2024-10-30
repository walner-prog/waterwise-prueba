
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pago</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Recibo de Pago</h1>
    <p><strong>Cliente:</strong> {{ $cliente->primer_nombre }} {{ $cliente->primer_apellido }}</p>
    <p><strong>Fecha del Pago:</strong> {{ $fechaPago }}</p>
    <p><strong>Método de Pago:</strong> {{ $metodoPago }}</p>

    <h3>Detalles de Facturas</h3>
    <table>
        <thead>
            <tr>
                <th>Factura No</th>
                <th>Fecha de Factura</th>
                <th>Lectura Anterior</th>
                <th>Lectura Actual</th>
                <th>Consumo (m³)</th>
                <th>Monto (C$)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facturas as $factura)
            <tr>
                <td>{{ $factura['numero_factura'] }}</td>
                <td>{{ $factura['fecha_factura'] }}</td>
                <td>{{ $factura['lectura_anterior'] }} m³</td>
                <td>{{ $factura['lectura_actual'] }} m³</td>
                <td>{{ $factura['consumo'] }} m³</td>
                <td>C${{ number_format($factura['monto'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Pagado: C${{ number_format($montoTotal, 2) }}</h3>
</body>
</html>
