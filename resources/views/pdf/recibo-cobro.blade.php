<!DOCTYPE html>
<html>
<head>
    <title>Recibo de Cobro</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; }
        p { font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 20px; font-size: 12px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Recibo de Cobro</h1>
        <p><strong>Remitente:</strong> CAPS WARTERWISE</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        <p><strong>Fecha de Vencimiento:</strong> {{ \Carbon\Carbon::now()->addDays(15)->format('d/m/Y') }}</p> <!-- Ajusta el número de días según tus necesidades -->
    </div>

    <p>{{ $detalleDeuda }}</p>
    <p>Por favor, realice el pago a la brevedad para evitar la suspensión del servicio.</p>
    <p>Gracias por su atención.</p>

    <div class="footer">
        <p>Atentamente,</p>
        <p>CAPS WATERWISE</p>
    </div>
</body>
</html>
