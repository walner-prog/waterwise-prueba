<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Medidor;

class MedidoresConDeuda extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = ''; // Para buscar por nombre de cliente
    public $mes = ''; // Para buscar por mes
    public $anio = ''; // Para buscar por año

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Obtener los medidores que tienen facturas pendientes y aplicar filtros
        $medidoresConDeuda = Medidor::whereHas('facturas', function ($query) {
                $query->where('estado_pago', 'pendiente'); // Solo facturas pendientes
            })
            ->with(['cliente', 'facturas' => function($query) {
                $query->where('estado_pago', 'pendiente'); // Solo facturas pendientes
            }])
            ->when($this->search, function ($query) {
                $query->whereHas('cliente', function ($q) {
                    $q->where('primer_nombre', 'like', '%' . $this->search . '%')
                      ->orWhere('primer_apellido', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->mes, function ($query) {
                $query->whereHas('facturas', function ($q) {
                    $q->whereMonth('fecha_factura', '=', $this->mes);
                });
            })
            ->when($this->anio, function ($query) {
                $query->whereHas('facturas', function ($q) {
                    $q->whereYear('fecha_factura', '=', $this->anio);
                });
            })
            ->paginate(5); // Paginar directamente

        return view('livewire.medidores-con-deuda', [
            'medidoresConDeuda' => $medidoresConDeuda,
        ]);
    }
}
