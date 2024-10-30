

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Lectura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .recibo-container {
            width: 350px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .recibo-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .recibo-header h1 {
            font-size: 18px;
            margin: 0;
        }

        .recibo-header img {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        .recibo-content {
            font-size: 14px;
        }

        .recibo-content .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .recibo-content .row .label {
            font-weight: bold;
        }

        .recibo-content .row .value {
            text-align: right;
            margin-top: -20px;
        }

        .recibo-content .notes {
            margin-top: 10px;
            font-size: 12px;
        }

        .recibo-footer {
            text-align: right;
            margin-top: 20px;
        }

        .signature {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .signature .sig-line {
            border-top: 1px solid #000;
            width: 45%;
            text-align: center;
            padding-top: 5px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="recibo-container">
        <div class="recibo-header">
            <h1>CAPS BETESDA</h1>
            <p><strong>Recibo de Lectura Nº</strong> {{ $id }}</p>
            <p><strong>Número de Medidor:</strong> {{ $numero_medidor }}</p>
        </div>

        <div class="recibo-content">
            <div class="row">
                <div class="label">RUC:</div>
                <div class="value">J0810000428851</div>
            </div>
            <div class="row">
                <div class="label">Usuario:</div>
                <div class="value">{{ $cliente_nombre }}</div>
            </div>
            <div class="row">
                <div class="label">Valor CS:</div>
                <div class="value">{{ number_format($consumo * $precio_por_m3, 2) }}</div>
            </div>
            
            <div class="row">
                <div class="label">Lectura Anterior:</div>
                <div class="value">{{ $lectura_anterior }}</div>
            </div>
            <div class="row">
                <div class="label">Lectura Actual:</div>
                <div class="value">{{ $lectura_actual }}</div>
            </div>
            <div class="row">
                <div class="label">Consumo de agua:</div>
                <div class="value">{{ $consumo }}</div>
            </div>
            <div class="row">
                <div class="label">Período del:</div>
                <div class="value">{{ $fecha_inicio }} al {{ $fecha_fin }}</div>
            </div>
            <div class="row">
                <div class="label">Mes leído:</div>
                <div class="value">{{ $mes_leido }}</div>
            </div>
            <div class="notes">
                <p>Pague su consumo a tiempo evitando el corte del servicio 5 días después de esta lectura, al no estar solvente.</p>
            </div>
            <div class="row">
                <div class="label">Fecha de lectura:</div>
                <div class="value">{{ $fecha_lectura }}</div>
            </div>
        </div>

        <div class="signature">
            <div class="sig-line">Firmado por</div>
            <div class="sig-line">Entregué conforme</div>
        </div>
    </div>
</body>
</html>

