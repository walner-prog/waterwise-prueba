<?php
namespace App\Http\Livewire;

use App\Models\Ingreso;
use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;
use Laravel\Ui\Presets\Bootstrap;
class HistorialPagos extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $clienteId;
    public $cliente;
    public $search = ''; // Nueva propiedad para búsqueda
    public $filtroMonto; // Nueva propiedad para filtrar por monto

    public function mount($clienteId)
    {
        $this->clienteId = $clienteId;
        $this->cliente = Cliente::findOrFail($clienteId);
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Resetea la paginación cuando se actualiza la búsqueda
    }

    public function updatingFiltroMonto()
    {
        $this->resetPage(); // Resetea la paginación cuando se actualiza el filtro de monto
    }

    public function render()
    {
        // Obtener el historial de pagos paginado y filtrado
        $historialPagos = Ingreso::whereHas('factura', function ($query) {
            $query->where('cliente_id', $this->clienteId);
        })
        ->with('factura')
        ->when($this->search, function($query) {
            $query->where('monto', 'like', '%' . $this->search . '%');
        })
        ->when($this->filtroMonto, function($query) {
            $query->where('monto', '>=', $this->filtroMonto);
        })
        ->paginate(5); // Define la cantidad de elementos por página

        return view('livewire.historial-pagos', [
            'historialPagos' => $historialPagos,
            'cliente' => $this->cliente
        ]);
    }
}

