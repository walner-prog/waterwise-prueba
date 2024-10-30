<div>
    <!-- resources/views/pdf/reporte-mensual.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Estado de Cuenta - {{ \Carbon\Carbon::create()->month($mes)->translatedFormat('F') }} {{ $anio }}</title>
    <style>
        body { font-family: sans-serif; }
        h1, h2, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Estado de Cuenta - {{ \Carbon\Carbon::create()->month($mes)->translatedFormat('F') }} {{ $anio }}</h1>

    <h2>Total de Ingresos</h2>
    <p>Se generaron {{ $totalIngresos }} de ingresos por {{ $numeroClientes }} clientes.</p>

    <h2>Ingresos Detallados</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ingresos as $ingreso)
                <tr>
                    <td>{{ $ingreso->fecha }}</td>
                    <td>{{ $ingreso->monto }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Total de Egresos</h2>
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
                    <td>{{ $egreso->monto }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Saldo del Mes</h2>
    <p>Saldo del Mes: {{ $saldoDelMes }}</p>

    <h2>Saldo Acumulado</h2>
    <p>Nuevo Saldo Acumulado: {{ $nuevoSaldoAcumulado }}</p>

    <h2>Mora Total del Mes</h2>
    <p>Mora Total: {{ $facturasEnMora }}</p>
</body>
</html>

</div>
