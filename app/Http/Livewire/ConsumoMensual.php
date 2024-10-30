<?php
// app/Http/Livewire/ConsumoMensual.php
// app/Http/Livewire/ConsumoMensual.php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LecturaMensual;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConsumoMensual extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap"; // Usamos Bootstrap para la paginación

    public $searchAnio = ''; // Búsqueda por año
    public $searchMes = '';  // Búsqueda por mes

    public function render()
    {
        \Carbon\Carbon::setLocale('es'); // Configurar Carbon en español

        // Consulta para obtener el consumo mensual filtrado por año y mes
        $consumosMensuales = LecturaMensual::select(
                DB::raw('YEAR(fecha_lectura) as anio'),
                DB::raw('MONTH(fecha_lectura) as mes'),
                DB::raw('SUM(consumo) as total_consumo')
            )
            ->when($this->searchAnio, function ($query) {
                // Filtrar por año si está presente
                $query->where(DB::raw('YEAR(fecha_lectura)'), $this->searchAnio);
            })
            ->when($this->searchMes, function ($query) {
                // Filtrar por mes si está presente
                $query->where(DB::raw('MONTH(fecha_lectura)'), $this->searchMes);
            })
            ->groupBy('anio', 'mes')
            ->paginate(5); // Cambia el número de paginación según sea necesario

        return view('livewire.consumo-mensual', compact('consumosMensuales'));
    }
}
