<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ingreso;
use App\Models\Egreso;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IngresosEgresosMensuales extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    public $searchAnio = ''; // Filtro por año
    public $searchMes = '';  // Filtro por mes

    public function render()
    {
        \Carbon\Carbon::setLocale('es'); // Configurar Carbon en español

        // Consulta para ingresos mensuales
        $ingresosMensuales = Ingreso::select(
                DB::raw('YEAR(fecha) as anio'),
                DB::raw('MONTH(fecha) as mes'),
                DB::raw('SUM(monto) as total_ingresos')
            )
            ->when($this->searchAnio, function ($query) {
                $query->where(DB::raw('YEAR(fecha)'), $this->searchAnio);
            })
            ->when($this->searchMes, function ($query) {
                $query->where(DB::raw('MONTH(fecha)'), $this->searchMes);
            })
            ->groupBy('anio', 'mes');

        // Consulta para egresos mensuales
        $egresosMensuales = Egreso::select(
                DB::raw('YEAR(fecha) as anio'),
                DB::raw('MONTH(fecha) as mes'),
                DB::raw('SUM(monto) as total_egresos')
            )
            ->when($this->searchAnio, function ($query) {
                $query->where(DB::raw('YEAR(fecha)'), $this->searchAnio);
            })
            ->when($this->searchMes, function ($query) {
                $query->where(DB::raw('MONTH(fecha)'), $this->searchMes);
            })
            ->groupBy('anio', 'mes');

        // Unir las consultas de ingresos y egresos
        $result = $ingresosMensuales
            ->leftJoinSub($egresosMensuales, 'egresos', function ($join) {
                $join->on('anio', '=', 'egresos.anio')
                     ->on('mes', '=', 'egresos.mes');
            })
            ->select(
                'anio',
                'mes',
                DB::raw('SUM(monto) as total_ingresos'),  // Suma de los ingresos
                DB::raw('IFNULL(egresos.total_egresos, 0) as total_egresos') // Egresos con IFNULL
            )
            ->groupBy('anio', 'mes', 'egresos.total_egresos') // Agrupar por año, mes y total_egresos
            ->orderBy('anio', 'asc')
            ->orderBy('mes', 'asc')
            ->paginate(5);

        return view('livewire.ingresos-egresos-mensuales', [
            'ingresosEgresos' => $result
        ]);
    }
}
