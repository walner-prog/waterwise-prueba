<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Factura;
use App\Models\LecturaMensual;
use App\Models\Medidor;
use App\Models\Tarifa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Mail\ReciboCobroMail;
use Illuminate\Support\Facades\Mail;

class FinanzaController extends Controller
{
    public function index()
    {
        $mes = now()->month; // O el mes que desees
        $anio = now()->year; // O el año que desees
    
        // Obtener los medidores con sus respectivos clientes y facturas pendientes
        $medidoresConDeuda = Medidor::with(['cliente', 'facturas' => function($query) {
            $query->where('estado_pago', 'pendiente');
        }])
        ->get()
        ->filter(function ($medidor) {
            return $medidor->facturas->isNotEmpty(); // Filtrar solo los medidores con facturas pendientes
        });
    
        return view('finanzas.index', compact('mes', 'anio', 'medidoresConDeuda'));
    }
    

    public function generateReport(Request $request, $mes, $anio)
    {

     // Obtener ingresos detallados por facturas, incluyendo la tarifa asociada y asegurando la carga de tarifa_id
$ingresosFacturas = Ingreso::whereMonth('fecha', $mes)
->whereYear('fecha', $anio)
->whereNull('venta_id') // Solo facturas
->with(['factura' => function ($query) {
    $query->with('tarifa:id,precio_por_m3'); // Cargar solo el ID y precio de tarifa
}])
->get();

// Calcular la suma en dinero tomando en cuenta la tarifa específica de cada factura
$totalIngresosFacturas = $ingresosFacturas->reduce(function ($carry, $ingreso) {
// Asegurarse de que cada ingreso tenga una factura y que esta tenga una tarifa
if ($ingreso->factura && $ingreso->factura->tarifa) {
    // Usar el monto total de la factura y ajustar el cálculo si es necesario
    $carry += $ingreso->factura->monto_total;
}
return $carry;
}, 0);
        
   // Obtener total de ingresos por ventas
    $totalIngresosVentas = Ingreso::whereMonth('fecha', $mes)
    ->whereYear('fecha', $anio)
    ->whereNotNull('venta_id') // Solo ingresos por ventas (con venta_id)
    ->sum('monto');

    // Calcular el total combinado de ingresos (si se necesita para el reporte)
     $totalIngresos = $totalIngresosFacturas + $totalIngresosVentas;
    
        // Obtener el total de ingresos por ventas
        $totalIngresosPorVentas = Ingreso::whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->whereNotNull('venta_id') // Solo considerar ingresos asociados a ventas
            ->sum('monto');
    
        // Obtener el número de clientes únicos basados en la relación con Factura
        $numeroClientesFacturas = Ingreso::whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->join('facturas', 'ingresos.factura_id', '=', 'facturas.id')
            ->distinct()
            ->count('facturas.cliente_id');
    
        // Obtener el número de clientes únicos basados en la relación con Venta
        $numeroClientesVentas = Ingreso::whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->whereNotNull('venta_id') // Solo considerar ingresos asociados a ventas
            ->join('ventas', 'ingresos.venta_id', '=', 'ventas.id')
            ->distinct()
            ->count('ventas.cliente_id');
    
        // Obtener la tarifa por metro cúbico (suponiendo que tomas la tarifa más reciente o la vigente)
        $tarifa = Tarifa::orderBy('fecha_vigencia', 'desc')->first();
    
        // Calcular total de metros cúbicos consumidos
        $totalMetrosCubicos = $tarifa ? ($totalIngresosFacturas / $tarifa->precio_por_m3) : 0;
    
        // Obtener los ingresos detallados
        $ingresos = Ingreso::whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();
       

// Obtener ingresos detallados por ventas
$ingresosVentas = Ingreso::whereMonth('fecha', $mes)
    ->whereYear('fecha', $anio)
    ->whereNotNull('venta_id') // Solo ventas
    ->with(['venta']) // Cargar la venta relacionada
    ->get();
    
        // Obtener total de egresos
        $totalEgresos = Egreso::whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->sum('monto');
    
        // Obtener los egresos detallados
        $egresosDetallados = Egreso::whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();
    
        // Calcular saldo del mes
        $saldoDelMes = $totalIngresos - $totalEgresos;
    
        // Obtener saldo acumulado
        $saldoAcumulado = DB::table('ingresos')
            ->where('fecha', '<', now()->startOfMonth()->subMonth())
            ->sum('monto') - DB::table('egresos')
            ->where('fecha', '<', now()->startOfMonth()->subMonth())
            ->sum('monto');
    
        // Calcular el nuevo saldo acumulado
        $nuevoSaldoAcumulado = $saldoAcumulado + $saldoDelMes;
    
        // Obtener facturas en mora
        $facturasEnMora = Factura::where('estado_pago', 'pendiente')
            ->whereMonth('fecha_factura', $mes)
            ->whereYear('fecha_factura', $anio)
            ->sum('monto_total');
    
        // Obtener mora de meses anteriores
        $facturasEnMoraAnterior = Factura::where('estado_pago', 'pendiente')
            ->where('fecha_factura', '<', now()->startOfMonth())
            ->sum('monto_total');
    
        // Generar PDF
        $pdf = PDF::loadView('pdf.reporte-mensual', [
            'totalIngresos' => $totalIngresos,
            'ingresosVentas' => $ingresosVentas,
            'ingresosFacturas' => $ingresosFacturas,
            'totalIngresosFacturas' => $totalIngresosFacturas,
            'totalIngresosVentas' => $totalIngresosVentas,
            'totalIngresosPorVentas' => $totalIngresosPorVentas, // Agregamos esta línea
            'numeroClientesFacturas' => $numeroClientesFacturas,
            'numeroClientesVentas' => $numeroClientesVentas, // Agregamos esta línea
            'totalMetrosCubicos' => $totalMetrosCubicos,
            'ingresos' => $ingresos,
            'totalEgresos' => $totalEgresos,
            'egresosDetallados' => $egresosDetallados,
            'saldoDelMes' => $saldoDelMes,
            'nuevoSaldoAcumulado' => $nuevoSaldoAcumulado,
            'facturasEnMora' => $facturasEnMora,
            'facturasEnMoraAnterior' => $facturasEnMoraAnterior,
            'mes' => $mes,
            'anio' => $anio,
        ]);
    
        return $pdf->stream("reporte-mensual-$mes-$anio.pdf");
    }
    
    

    public function generarReciboCobro($clienteId)
{
    // Obtener el cliente
    $cliente = Cliente::find($clienteId);

    // Obtener las facturas pendientes del cliente
    $facturasPendientes = Factura::where('cliente_id', $clienteId)
        ->where('estado_pago', 'pendiente')
        ->get();

    // Si el cliente no tiene deudas
    if ($facturasPendientes->isEmpty()) {
        return "El cliente no tiene deudas pendientes.";
    }

    // Construir el párrafo de recibo
    $detalleDeuda = "Estimado/a {$cliente->primer_nombre} {$cliente->primer_apellido}, ";
    $detalleDeuda .= "usted debe la cantidad de ";

    $totalDeuda = 0;
    foreach ($facturasPendientes as $factura) {
        $totalDeuda += $factura->monto_total;
        $detalleDeuda .= "{$factura->monto_total} Córdobas correspondiente al mes de " . \Carbon\Carbon::parse($factura->fecha_factura)->format('F Y') . ". ";
    }

    $detalleDeuda .= "El total de su deuda es de {$totalDeuda} Córdobas. ";

    // Puedes agregar más información si es necesario

    // Retornar el recibo o generar un PDF
    return $detalleDeuda;
}

public function generarReciboCobroPdf($clienteId)
{
    // Obtener el cliente
    $cliente = Cliente::find($clienteId);

    // Obtener las facturas pendientes del cliente
    $facturasPendientes = Factura::where('cliente_id', $clienteId)
        ->where('estado_pago', 'pendiente')
        ->get();

    // Si el cliente no tiene deudas
    if ($facturasPendientes->isEmpty()) {
        return response()->json(['message' => 'El cliente no tiene deudas pendientes.'], 404);
    }

    // Construir el detalle del recibo
    $detalleDeuda = "Estimado/a {$cliente->primer_nombre} {$cliente->segundo_nombre} {$cliente->primer_apellido} {$cliente->segundo_apellido}, ";
    $detalleDeuda .= "usted debe la cantidad de: ";

    $totalDeuda = 0;
    foreach ($facturasPendientes as $factura) {
        $totalDeuda += $factura->monto_total;
        $detalleDeuda .= "{$factura->monto_total} Córdobas correspondiente al mes de " . \Carbon\Carbon::parse($factura->fecha_factura)->translatedFormat('F Y') . ". ";
    }

    $detalleDeuda .= "El total de su deuda es de {$totalDeuda} Córdobas. ";
    $detalleDeuda .= "Le invitamos a cancelar su deuda de {$totalDeuda} Córdobas lo antes posible.";

    // Generar PDF
    $pdf = PDF::loadView('pdf.recibo-cobro', [
        'detalleDeuda' => $detalleDeuda,
        'cliente' => $cliente,
        'totalDeuda' => $totalDeuda,
    ]);

    return $pdf->stream("recibo-cobro-{$clienteId}.pdf");
}
public function enviarReciboPorWhatsApp($clienteId)
{
    // Obtener el cliente
    $cliente = Cliente::find($clienteId);

    // Verificar si el cliente tiene un número de teléfono
    if (empty($cliente->telefono)) {
        return response()->json(['message' => 'El cliente no tiene un número de teléfono registrado.'], 404);
    }

    // Obtener las facturas pendientes del cliente
    $facturasPendientes = Factura::where('cliente_id', $clienteId)
        ->where('estado_pago', 'pendiente')
        ->get();

    // Si el cliente no tiene deudas
    if ($facturasPendientes->isEmpty()) {
        return response()->json(['message' => 'El cliente no tiene deudas pendientes.'], 404);
    }

    // Construir el detalle del recibo
    $detalleDeuda = "Estimado/a {$cliente->primer_nombre} {$cliente->segundo_nombre} {$cliente->primer_apellido} {$cliente->segundo_apellido}, ";
    $detalleDeuda .= "usted debe la cantidad de:  ";

    $totalDeuda = 0;
    foreach ($facturasPendientes as $factura) {
        $totalDeuda += $factura->monto_total;
        $detalleDeuda .= "{$factura->monto_total} Córdobas correspondiente al mes de " . \Carbon\Carbon::parse($factura->fecha_factura)->translatedFormat('F Y') . ". ";
    }

    $detalleDeuda .= "El total de su deuda es de {$totalDeuda} Córdobas. ";
    $detalleDeuda .= "Le invitamos a cancelar su deuda de {$totalDeuda} Córdobas lo antes posible.";

    // Generar el recibo de cobro
    $pdf = PDF::loadView('pdf.recibo-cobro', [
        'detalleDeuda' => $detalleDeuda,
        'cliente' => $cliente,
        'totalDeuda' => $totalDeuda,
    ]);

    // Guardar el PDF en un directorio temporal
    $pdfPath = storage_path("app/public/recibos/recibo-cobro-{$clienteId}.pdf");
    $pdf->save($pdfPath);

    // Crear una URL pública para el PDF
    $urlPdf = url("storage/recibos/recibo-cobro-{$clienteId}.pdf");

    // Crear un mensaje de WhatsApp con el enlace al PDF
    $mensaje = "Estimado/a {$cliente->primer_nombre}, le enviamos su recibo de cobro. Por favor, verifique su deuda: {$urlPdf}";
    $mensaje = urlencode($mensaje);
    $telefono = urlencode($cliente->telefono);
    $urlWhatsApp = "https://api.whatsapp.com/send?phone={$telefono}&text={$mensaje}";

    // Redirigir al usuario a WhatsApp para enviar el mensaje
    return redirect()->away($urlWhatsApp);
}



public function enviarReciboPorCorreo($clienteId)
{ 
    // Obtener el cliente
    $cliente = Cliente::find($clienteId);

    // Verificar si el cliente tiene un correo electrónico
    if (empty($cliente->email)) {
        return response()->json(['message' => 'El cliente no tiene un correo electrónico registrado.'], 404);
    }

    // Obtener las facturas pendientes del cliente
    $facturasPendientes = Factura::where('cliente_id', $clienteId)
        ->where('estado_pago', 'pendiente')
        ->get();

    // Si el cliente no tiene deudas
    if ($facturasPendientes->isEmpty()) {
        return response()->json(['message' => 'El cliente no tiene deudas pendientes.'], 404);
    }

    // Construir el detalle del recibo
    $detalleDeuda = "Estimado/a {$cliente->primer_nombre} {$cliente->segundo_nombre} {$cliente->primer_apellido} {$cliente->segundo_apellido}, ";
    $detalleDeuda .= "usted debe la cantidad de:  ";

    $totalDeuda = 0;
    foreach ($facturasPendientes as $factura) {
        $totalDeuda += $factura->monto_total;
        $detalleDeuda .= "{$factura->monto_total} Córdobas correspondiente al mes de " . \Carbon\Carbon::parse($factura->fecha_factura)->translatedFormat('F Y') . ". ";
    }

    $detalleDeuda .= "El total de su deuda es de {$totalDeuda} Córdobas. ";
    $detalleDeuda .= "Le invitamos a cancelar su deuda de {$totalDeuda} Córdobas lo antes posible.";

    // Generar el recibo de cobro en PDF
    $pdf = PDF::loadView('pdf.recibo-cobro', [
        'detalleDeuda' => $detalleDeuda,
        'cliente' => $cliente,
        'totalDeuda' => $totalDeuda,
    ]);

    // Guardar el PDF en un directorio temporal
    $pdfPath = storage_path("app/public/recibos/recibo-cobro-{$clienteId}.pdf");
    $pdf->save($pdfPath);

    // Enviar el correo con el PDF adjunto
    Mail::to($cliente->email)->send(new ReciboCobroMail($cliente, $pdfPath));

 
    return redirect()->route('finanzas.index')->with('info', 'Recibo de cobro enviado por correo electrónico correctamente.');
}



}
