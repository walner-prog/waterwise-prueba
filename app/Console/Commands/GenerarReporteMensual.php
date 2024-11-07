<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;
use App\Models\Tarifa;
use App\Models\Reporte;

class GenerarReporteMensual extends Command
{
    protected $signature = 'reporte:generar-mensual';
    protected $description = 'Generar y guardar el reporte mensual de ingresos y egresos en formato PDF';

    public function handle()
    {
        $mes = now()->month;
        $anio = now()->year;
        $fechaInicioMes = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fechaFinMes = Carbon::create($anio, $mes, 1)->endOfMonth();

        // Ingresos por facturas (sin ventas) con tarifas
    $ingresosFacturas = Ingreso::whereBetween('fecha', [$fechaInicioMes, $fechaFinMes])
    ->whereNull('venta_id')
    ->with(['factura' => function ($query) {
        $query->with('tarifa:id,precio_por_m3');
    }])
    ->get();

$totalIngresosFacturas = $ingresosFacturas->reduce(function ($carry, $ingreso) {
    if ($ingreso->factura && $ingreso->factura->tarifa) {
        $carry += $ingreso->factura->monto_total;
    }
    return $carry;
}, 0);

// Ingresos totales de ventas
$totalIngresosVentas = Ingreso::whereBetween('fecha', [$fechaInicioMes, $fechaFinMes])
    ->whereNotNull('venta_id')
    ->sum('monto');

// Total de ingresos combinados
$totalIngresos = $totalIngresosFacturas + $totalIngresosVentas;

// Número de clientes únicos por facturas
$numeroClientesFacturas = Ingreso::whereBetween('fecha', [$fechaInicioMes, $fechaFinMes])
    ->join('facturas', 'ingresos.factura_id', '=', 'facturas.id')
    ->distinct()
    ->count('facturas.cliente_id');

// Número de clientes únicos por ventas
$numeroClientesVentas = Ingreso::whereBetween('fecha', [$fechaInicioMes, $fechaFinMes])
    ->whereNotNull('venta_id')
    ->join('ventas', 'ingresos.venta_id', '=', 'ventas.id')
    ->distinct()
    ->count('ventas.cliente_id');

// Tarifa por metro cúbico (última tarifa)
$tarifa = Tarifa::orderBy('fecha_vigencia', 'desc')->first();

// Total metros cúbicos consumidos
$totalMetrosCubicos = $tarifa ? ($totalIngresosFacturas / $tarifa->precio_por_m3) : 0;

// Detalles de ingresos
$ingresos = Ingreso::whereBetween('fecha', [$fechaInicioMes, $fechaFinMes])->get();
$ingresosVentas = Ingreso::whereBetween('fecha', [$fechaInicioMes, $fechaFinMes])
    ->whereNotNull('venta_id')
    ->with(['venta'])
    ->get();

// Egresos totales y detallados
$totalEgresos = Egreso::whereBetween('fecha', [$fechaInicioMes, $fechaFinMes])->sum('monto');
$egresosDetallados = Egreso::whereBetween('fecha', [$fechaInicioMes, $fechaFinMes])->get();

// Calcular saldo del mes
$saldoDelMes = $totalIngresos - $totalEgresos;

// Saldo acumulado hasta el mes anterior
$saldoAcumulado = DB::table('ingresos')
    ->where('fecha', '<', now()->startOfMonth())
    ->sum('monto') 
    - DB::table('egresos')
    ->where('fecha', '<', now()->startOfMonth())
    ->sum('monto');

// Nuevo saldo acumulado con el saldo del mes
$nuevoSaldoAcumulado = $saldoAcumulado + $saldoDelMes;

// Facturas en mora del mes y anteriores
$facturasEnMora = Factura::where('estado_pago', 'pendiente')
    ->whereMonth('fecha_factura', $mes)
    ->whereYear('fecha_factura', $anio)
    ->sum('monto_total');

$facturasEnMoraAnterior = Factura::where('estado_pago', 'pendiente')
    ->where('fecha_factura', '<', now()->startOfMonth())
    ->sum('monto_total');

// Generar PDF con los datos necesarios
$pdf = PDF::loadView('pdf.reporte-mensual', [
    'totalIngresos' => $totalIngresos,
    'ingresosVentas' => $ingresosVentas,
    'ingresosFacturas' => $ingresosFacturas,
    'totalIngresosFacturas' => $totalIngresosFacturas,
    'totalIngresosVentas' => $totalIngresosVentas,
    'numeroClientesFacturas' => $numeroClientesFacturas,
    'numeroClientesVentas' => $numeroClientesVentas,
    'totalMetrosCubicos' => $totalMetrosCubicos,
    'ingresos' => $ingresos,
    'totalEgresos' => $totalEgresos,
    'egresosDetallados' => $egresosDetallados,
    'saldoDelMes' => $saldoDelMes,
    'saldoAcumulado' => $saldoAcumulado,
    'nuevoSaldoAcumulado' => $nuevoSaldoAcumulado,
    'facturasEnMora' => $facturasEnMora,
    'facturasEnMoraAnterior' => $facturasEnMoraAnterior,
    'mes' => $mes,
    'anio' => $anio,
]);


       // Definir el nombre del archivo y la ruta
    $fileName = "reporte-mensual-{$mes}-{$anio}.pdf";
    $filePath = "reportes/{$fileName}";

    // Guardar el archivo PDF en el almacenamiento local
    Storage::put($filePath, $pdf->output());

    // Guardar el registro del reporte en la base de datos
    Reporte::create([
        'nombre' => "Reporte Mensual {$mes}/{$anio}",
        'ruta' => $filePath,
        'fecha' => now(), // Fecha actual de generación
    ]);

        $this->info("Reporte mensual {$fileName} generado y guardado con éxito.");
    }
}
