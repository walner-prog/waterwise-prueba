<?php
// app/Http/Livewire/ReporteMensual.php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf;
class ReporteMensual extends Component
{
    public $mes;
    public $anio;

    public function mount($mes, $anio)
    {
        $this->mes = $mes;
        $this->anio = $anio;
    }

    public function generarReporte()
    {
        // Obtener total de ingresos
        $totalIngresos = Ingreso::whereMonth('fecha', $this->mes)
            ->whereYear('fecha', $this->anio)
            ->sum('monto');
    
        // Obtener el número de clientes únicos (cambia 'cliente_id' al nombre correcto)
        $numeroClientes = Ingreso::whereMonth('fecha', $this->mes)
            ->whereYear('fecha', $this->anio)
            ->distinct('cliente_id') // Cambia esto si es necesario
            ->count();
    
        // Obtener los ingresos detallados
        $ingresosDetallados = Ingreso::whereMonth('fecha', $this->mes)
            ->whereYear('fecha', $this->anio)
            ->get(); // Asegúrate de que estás recuperando los ingresos aquí
    
        // Obtener total de egresos
        $totalEgresos = Egreso::whereMonth('fecha', $this->mes)
            ->whereYear('fecha', $this->anio)
            ->sum('monto');
    
        // Obtener los egresos detallados
        $egresosDetallados = Egreso::whereMonth('fecha', $this->mes)
            ->whereYear('fecha', $this->anio)
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
        $facturasEnMora = Factura::where('estado', 'mora')
            ->whereMonth('fecha', $this->mes)
            ->whereYear('fecha', $this->anio)
            ->sum('monto');
    
        // Generar el PDF
        $pdf = PDF::loadView('pdf.reporte-mensual', [
            'mes' => $this->mes,
            'anio' => $this->anio,
            'totalIngresos' => $totalIngresos,
            'numeroClientes' => $numeroClientes, // Asegúrate de pasar esto
            'ingresos' => $ingresosDetallados, // Pasa los ingresos detallados
            'totalEgresos' => $totalEgresos,
            'egresosDetallados' => $egresosDetallados,
            'saldoDelMes' => $saldoDelMes,
            'nuevoSaldoAcumulado' => $nuevoSaldoAcumulado,
            'facturasEnMora' => $facturasEnMora,
        ]);
    
        // Descargar el PDF
        return $pdf->pdf("reporte-mensual-{$this->mes}-{$this->anio}.pdf");
    }
    


    public function render()
    {
        // Obtener total de ingresos
        $totalIngresos = Ingreso::whereMonth('fecha', $this->mes)
            ->whereYear('fecha', $this->anio)
            ->sum('monto');
    
        // Obtener el número de clientes únicos basados en la relación con Factura
        $numeroClientes = Ingreso::whereMonth('fecha', $this->mes)
            ->whereYear('fecha', $this->anio)
            ->join('facturas', 'ingresos.factura_id', '=', 'facturas.id')
            ->distinct('facturas.cliente_id')
            ->count('facturas.cliente_id');
    
        // Obtener los ingresos detallados
        $ingresos = Ingreso::whereMonth('fecha', $this->mes)
            ->whereYear('fecha', $this->anio)
            ->get();
    
        // Obtener total de egresos
        $totalEgresos = Egreso::whereMonth('fecha', $this->mes)
            ->whereYear('fecha', $this->anio)
            ->sum('monto');
    
        // Obtener los egresos detallados
        $egresosDetallados = Egreso::whereMonth('fecha', $this->mes)
            ->whereYear('fecha', $this->anio)
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
    
        // Obtener facturas en mora (considerando que 'pendiente' es el estado que indica mora)
        $facturasEnMora = Factura::where('estado_pago', 'pendiente')
            ->whereMonth('fecha_factura', $this->mes)
            ->whereYear('fecha_factura', $this->anio)
            ->sum('monto_total'); // Asegúrate de que 'monto_total' es el nombre correcto de la columna
    
        return view('livewire.reporte-mensual', [
            'totalIngresos' => $totalIngresos,
            'numeroClientes' => $numeroClientes,
            'ingresos' => $ingresos,
            'totalEgresos' => $totalEgresos,
            'egresosDetallados' => $egresosDetallados,
            'saldoDelMes' => $saldoDelMes,
            'nuevoSaldoAcumulado' => $nuevoSaldoAcumulado,
            'facturasEnMora' => $facturasEnMora,
        ]);
    }
    


}
