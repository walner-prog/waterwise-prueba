<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;

class RelacionIngresosFacturacion extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap"; // Usamos Bootstrap para la paginación

    public $searchAnio = ''; // Búsqueda por año
    public $searchMes = '';  // Búsqueda por mes

    public function render()
    {
        // Consulta para comparar el total facturado con el total de ingresos por cliente
        $comparativaFacturacionIngresos = Factura::select(
                'cliente_id',
                DB::raw('SUM(monto_total) as total_facturado'),
                DB::raw('SUM(ingresos.monto) as total_ingresos')
            )
            ->leftJoin('ingresos', 'facturas.id', '=', 'ingresos.factura_id')
            ->when($this->searchAnio, function ($query) {
                // Filtrar por año si está presente
                $query->where(DB::raw('YEAR(facturas.fecha_factura)'), $this->searchAnio);
            })
            ->when($this->searchMes, function ($query) {
                // Filtrar por mes si está presente
                $query->where(DB::raw('MONTH(facturas.fecha_factura)'), $this->searchMes);
            })
            ->groupBy('cliente_id')
            ->paginate(5); // Ajusta la paginación según sea necesario

        return view('livewire.relacion-ingresos-facturacion', compact('comparativaFacturacionIngresos'));
    }
}
