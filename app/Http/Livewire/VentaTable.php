<?php
namespace App\Http\Livewire;

use App\Models\Venta;
use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;

class VentaTable extends Component
{
    use WithPagination;

    public $search = '';
    public $modalOpen = false;
    public $editMode = false;
    public $ventaId;
    public $producto_id;
    public $cantidad;
    public $precio_venta;
    public $total_pagar;
    public $descripcion;
    public $cliente_id;
    public $stok_disponible;

    protected $rules = [
        'producto_id' => 'required|exists:productos,id',
        'cantidad' => 'required|integer|min:1',
        'cliente_id' => 'required|exists:clientes,id'
    ];

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetFields();
        $this->modalOpen = true;
    }

    public function edit($id)
    {
        $this->resetFields();
        $this->editMode = true;
        $this->ventaId = $id;
        $venta = Venta::findOrFail($id);
        $this->fill($venta->toArray());
        $this->modalOpen = true;
    }

    public function updatedProductoId($value)
    {
        if ($value) {
            $producto = Producto::find($value);

            if ($producto) {
                $this->precio_venta = $producto->precio_venta;

                if (is_numeric($this->cantidad) && $this->cantidad > 0) {
                    $this->total_pagar = $this->precio_venta * (float)$this->cantidad;
                } else {
                    $this->total_pagar = 0;
                }
            } else {
                $this->precio_venta = null;
                $this->total_pagar = null;
            }
        } else {
            $this->precio_venta = null;
            $this->total_pagar = null;
        }
    }

    public function updatedCantidad($value)
    {
       

        $producto = Producto::find($this->producto_id);

        if ($producto && $value > $producto->stok) {
            $this->addError('cantidad', 'La cantidad supera el stock disponible de ' . $producto->stok);
        } else {
            $this->resetErrorBag('cantidad');
        }

        if (is_numeric($this->precio_venta) && is_numeric($value) && $value > 0) {
            $this->total_pagar = (float)$this->precio_venta * (float)$value;
        } else {
            $this->total_pagar = 0;
        }
    }

    public function save()
    {
        $this->validate();

        $producto = Producto::find($this->producto_id);

        if ($producto && $this->cantidad > $producto->stok) {
            $this->addError('cantidad', 'La cantidad supera el stock disponible.');
            return;
        }

        $data = [
            'producto_id' => $this->producto_id,
            'cantidad' => $this->cantidad,
            'cliente_id' => $this->cliente_id,
            'precio_venta' => $this->precio_venta,
            'total_pagar' => $this->total_pagar,
            'descripcion' => $this->descripcion,
        ];

        if ($this->editMode) {
            $venta = Venta::findOrFail($this->ventaId);
            $venta->update($data);
            $this->dispatchBrowserEvent('venta-notification', ['type' => 'updated']);
        } else {
            Venta::create($data);
            $this->dispatchBrowserEvent('venta-notification', ['type' => 'created']);
        }
       
        $this->modalOpen = false;
        $this->resetFields();
    }

    public function delete($id)
    {
        Venta::findOrFail($id)->delete();
        $this->dispatchBrowserEvent('venta-notification', ['type' => 'deleted']);
    }

    public function resetFields()
    {
        $this->editMode = false;
        $this->ventaId = null;
        $this->producto_id = '';
        $this->cantidad = '';
        $this->precio_venta = '';
        $this->total_pagar = '';
        $this->descripcion = '';
    }

    public function render()
    {
       
        $ventas = Venta::with('producto', 'cliente')
            ->whereHas('producto', function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%');
            })
            ->paginate(5);

        $productos = Producto::all();
        $clientes = Cliente::all();
        return view('livewire.venta-table', [
            'ventas' => $ventas,
            'productos' => $productos,
            'clientes' => $clientes,
          
        ]);
    }
}
