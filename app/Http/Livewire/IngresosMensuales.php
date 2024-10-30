<?php
// app/Http/Livewire/IngresosMensuales.php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ingreso;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IngresosMensuales extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap"; // Usamos Bootstrap para la paginación

    public $searchAnio = ''; // Búsqueda por año
    public $searchMes = '';  // Búsqueda por mes

    public function render()
    {
        \Carbon\Carbon::setLocale('es'); // Configurar Carbon en español

        // Consulta para obtener ingresos mensuales filtrados por año y mes
        $ingresosMensuales = Ingreso::select(
                DB::raw('YEAR(fecha) as anio'),
                DB::raw('MONTH(fecha) as mes'),
                DB::raw('SUM(monto) as total_ingresos')
            )
            ->when($this->searchAnio, function ($query) {
                // Filtrar por año si está presente
                $query->where(DB::raw('YEAR(fecha)'), $this->searchAnio);
            })
            ->when($this->searchMes, function ($query) {
                // Filtrar por mes si está presente
                $query->where(DB::raw('MONTH(fecha)'), $this->searchMes);
            })
            ->groupBy('anio', 'mes')
            ->paginate(5); // Cambia el número de paginación según sea necesario

        return view('livewire.ingresos-mensuales', compact('ingresosMensuales'));
    }
}
