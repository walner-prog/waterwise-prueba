<?php

// app/Http/Livewire/FacturasPorCliente.php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;

class FacturasPorCliente extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap"; // Usamos Bootstrap para la paginación

    public $search = ''; // Búsqueda por nombre de cliente

    public function render()
    {
        // Consultar facturas pagadas por cliente
        $facturasPorCliente = Factura::with('cliente')
            ->select('cliente_id', 
                DB::raw('COUNT(*) as total_facturas'), // Total de facturas emitidas
                DB::raw('SUM(CASE WHEN ingreso.factura_id IS NOT NULL THEN 1 ELSE 0 END) as total_facturas_pagadas')) // Facturas pagadas
            ->leftJoin('ingresos as ingreso', 'facturas.id', '=', 'ingreso.factura_id')
            ->when($this->search, function($query) {
                $query->whereHas('cliente', function($q) {
                    $q->where('primer_nombre', 'like', '%' . $this->search . '%');
                });
            })
            ->groupBy('cliente_id')
            ->paginate(5);

        return view('livewire.facturas-por-cliente', compact('facturasPorCliente'));
    }
}
