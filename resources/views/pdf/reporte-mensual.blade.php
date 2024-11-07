<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Cuenta - {{ \Carbon\Carbon::create()->month($mes)->translatedFormat('F') }} {{ $anio }}</title>
    <style>
        body { 
            font-family: sans-serif; 
            margin: 20px; 
        }
        h1, h2, h3 { 
            text-align: center; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
        }
        th { 
            background-color: #f2f2f2; 
        }
        .row {
            display: flex; /* Utiliza flexbox para alinear las columnas */
            justify-content: space-between; /* Espacio uniforme entre columnas */
            margin-top: 20px; /* Espacio superior para separar de la tabla */
        }
        .col {
            flex: 1; /* Cada columna tomará el mismo espacio */
            margin: 0 10px; /* Espacio entre columnas */
            padding: 10px; /* Espacio interno */
          /*  border: 1px solid #ddd; /* Borde para distinguir columnas */
            border-radius: 5px; /* Bordes redondeados */
            background-color: #f9f9f9; /* Color de fondo suave */
            min-width: 200px; /* Ancho mínimo para columnas */
        }
        .badge-info{
            background-color: cornflowerblue;
            border-radius: 5px;
            color:black;
            padding: 5px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Estado de Cuenta - {{ \Carbon\Carbon::create()->month($mes)->translatedFormat('F') }} {{ $anio }}</h1>

    <h2>Total de Ingresos de {{ \Carbon\Carbon::create()->month($mes)->translatedFormat('F') }} {{ $anio }}</h2>
    <p>Se generaron en total <strong>{{ $totalIngresos }} C$</strong>  de los cuales <strong>{{ $totalIngresosFacturas }} C$</strong>  son  de pagos por servicio de agua  provenientes de  {{ $numeroClientesFacturas }} clientes, equivalentes a <strong>{{ $totalMetrosCubicos }}</strong> metros cúbicos.</p>
    <p>De los <strong>{{ $totalIngresos }} C$</strong>  <strong> {{ $totalIngresosVentas }} C$</strong> provienen de <strong>{{ $numeroClientesVentas }}</strong> clientes que realizaron compras de productos.</p>
    

 

    <h2>Total de Egresos de  {{ \Carbon\Carbon::create()->month($mes)->translatedFormat('F') }} {{ $anio }}</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Pagado A</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($egresosDetallados as $egreso)
                <tr>
                    <td>{{ $egreso->fecha }}</td>
                    <td>{{ $egreso->descripcion }}</td>
                    <td>{{ $egreso->pagado_a }}</td>
                    <td><span class=" badge badge-info">{{ $egreso->monto }} C$</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col">
            <h4>Saldo del Mes</h4>
            <p>Saldo del Mes: <strong>{{ $saldoDelMes }} </strong>C$</p>
            <p>Este es el resultado de los ingresos del mes <strong>({{ $totalIngresos }} C$)</strong> menos los egresos del mes <strong>({{ $totalEgresos }} C$)</strong> .</p>
        </div>
        
        <div class="col">
            <h4>Saldo Acumulado</h4>
            <p>Nuevo Saldo Acumulado: <strong>{{ $nuevoSaldoAcumulado }}</strong> C$</p>
            <p>Este saldo es el saldo acumulado  anterior que era de <strong>{{ $saldoAcumulado }} C$</strong> más el saldo del mes que fue de <strong>{{ $saldoDelMes }} C$</strong>.</p>
        </div>
        
        <div class="col">
            <h4>Mora Total del Mes</h4>
            <p>Mora Total: {{ $facturasEnMora }} (incluyendo {{ $facturasEnMoraAnterior }} de meses anteriores).</p>
            <p>Este total se calcula sumando los montos de las facturas en estado de mora (pendiente) del mes.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
