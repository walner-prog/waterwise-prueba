<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Egreso</title>
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
        <h1>COMITÉ DE AGUA POTABLE Y<br>SANEAMIENTO BETESDA, CAPS BETESDA</h1>
        <h2>Recibo de Egreso Nº {{ $id }}</h2>
        
        <p>RUC: J0810000428851</p>
        <p>Valor: <strong>C$ {{ number_format($monto, 2) }}</strong></p>
    </div>

    <div class="recibo-body">
        <table>
            <tr>
                <td>Páguese a:</td>
                <td>{{ $pagado_a }}</td>
            </tr>
            <tr>
                <td>Descripción:</td>
                <td>{{ $descripcion }}</td>
            </tr>
            <tr>
                <td>Empleado responsable:</td>
                <td>{{ $empleado_nombre }}</td>
            </tr>
            <tr>
                <td>Fecha:</td>
                <td>{{ $fecha }}</td>
            </tr>
        </table>
    </div>

    <div class="cancelado">
        <p>RECIBIDO</p>
    </div>

    <div class="firma">
        <p>Entregué conforme: <strong>Esmeralda Pérez</strong></p>
    </div>
</div>

</body>
</html>
