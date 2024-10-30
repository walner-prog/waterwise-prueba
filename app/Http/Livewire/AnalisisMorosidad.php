<?php
// app/Http/Livewire/AnalisisMorosidad.php
// app/Http/Livewire/AnalisisMorosidad.php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;

class AnalisisMorosidad extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $searchAnio = ''; // Filtro por año
    public $searchMes = '';  // Filtro por mes

    public function render()
    {
        // Consulta para obtener las facturas morosas (facturas sin ingresos asociados)
        $facturasMorosas = Factura::with('cliente') // Cargar relación cliente
            ->leftJoin('ingresos', 'facturas.id', '=', 'ingresos.factura_id')
            ->leftJoin('clientes', 'facturas.cliente_id', '=', 'clientes.id') // Unir la tabla clientes
            ->select(
                'facturas.cliente_id',
                'clientes.primer_nombre as nombre_cliente',  // Nombre del cliente
                'clientes.primer_apellido as apellido_cliente', // Apellido del cliente
                DB::raw('COUNT(*) as total_facturas_morosas'),
                'facturas.fecha_factura'
            )
            ->whereNull('ingresos.factura_id')
            ->when($this->searchAnio, function ($query) {
                // Filtrar por año si está presente
                $query->where(DB::raw('YEAR(facturas.fecha_factura)'), $this->searchAnio);
            })
            ->when($this->searchMes, function ($query) {
                // Filtrar por mes si está presente
                $query->where(DB::raw('MONTH(facturas.fecha_factura)'), $this->searchMes);
            })
            ->groupBy('facturas.cliente_id', 'clientes.primer_nombre', 'clientes.primer_apellido', 'facturas.fecha_factura') // Agrupar también por el apellido del cliente
            ->paginate(5); // Ajusta la paginación según sea necesario

        // Procesar los resultados para agregar el mes
        $facturasMorosas->transform(function ($factura) {
            $factura->mes_mora = \Carbon\Carbon::parse($factura->fecha_factura)->translatedFormat('F'); // Obtener mes
            return $factura;
        });

        return view('livewire.analisis-morosidad', compact('facturasMorosas'));
    }
}
