<?php
// app/Http/Livewire/IngresosPorCliente.php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ingreso;
use Illuminate\Support\Facades\DB;

class IngresosPorCliente extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $search = '';

    public function render()
{
    $ingresosPorCliente = Ingreso::with(['factura.cliente', 'factura.lecturaMensual'])
        ->whereHas('factura.cliente', function ($query) {
            $query->where('primer_nombre', 'like', '%' . $this->search . '%');
        })
        ->select('factura_id', DB::raw('SUM(monto) as total_ingresos'))
        ->groupBy('factura_id')
        ->paginate(5);

    return view('livewire.ingresos-por-cliente', compact('ingresosPorCliente'));
}

}
