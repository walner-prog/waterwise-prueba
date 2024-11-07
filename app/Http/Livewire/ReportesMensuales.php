<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reporte;
use Carbon\Carbon;

class ReportesMensuales extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap"; // Usamos Bootstrap para la paginación

    public $searchAnio = ''; // Búsqueda por año
    public $searchMes = '';  // Búsqueda por mes

    public function render()
    {
        $reportes = Reporte::orderBy('fecha', 'desc')
            ->when($this->searchAnio, function ($query) {
                $query->whereYear('fecha', $this->searchAnio);
            })
            ->when($this->searchMes, function ($query) {
                $query->whereMonth('fecha', $this->searchMes);
            })
            ->paginate(10); // Cambia el número de paginación según sea necesario

        return view('livewire.reportes-mensuales', [
            'reportes' => $reportes,
            'years' => $this->getYears(),
            'months' => $this->getMonths(),
        ]);
    }

    private function getYears()
    {
        return range(now()->year - 5, now()->year); // Opciones de año, por ejemplo, desde 5 años atrás hasta el año actual
    }

    private function getMonths()
    {
        return [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];
    }
}
