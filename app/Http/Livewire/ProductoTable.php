<?php

namespace App\Http\Livewire;

use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
class ProductoTable extends Component
{
    use WithPagination;

    public $search = '';
    public $stockFilter = '';
    public $lowStockFilter = false;
    public $modalOpen = false;
    public $editMode = false;
    public $productoId;
    public $nombre;
    public $descripcion;
    public $stok;
    public $precio_compra;
    public $precio_venta;
    public $fecha_creacion;
    public $hasLowStockProducts = false;

    protected $rules = [
       // 'nombre' => 'required|string|regex:/^[a-zA-Z\s]+$/',
       // 'descripcion' => 'required|string|regex:/^[a-zA-Z\s]+$/',
        'stok' => 'required|integer|min:1|max:120',
        'precio_compra' => 'required|numeric|min:1',
        'precio_venta' => 'required|numeric|min:1',
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
        $this->productoId = $id;
        $producto = Producto::findOrFail($id);
        $this->fill($producto->toArray());
        $this->modalOpen = true;
    }

    public function save()
{
    $this->validate();

    $data = [
        'nombre' => $this->nombre,
        'descripcion' => $this->descripcion,
        'stok' => $this->stok,
        'precio_compra' => $this->precio_compra,
        'precio_venta' => $this->precio_venta,
    ];

    if ($this->editMode) {
        $producto = Producto::findOrFail($this->productoId);
        $producto->update($data);
        $this->dispatchBrowserEvent('product-notification', ['type' => 'updated']);
    } else {
        Producto::create($data);
        $this->dispatchBrowserEvent('product-notification', ['type' => 'created']);
    }

    $this->modalOpen = false;
    $this->resetFields();
}

public function delete($id)
{
    Producto::findOrFail($id)->delete();
    $this->dispatchBrowserEvent('product-notification', ['type' => 'deleted']);
}

    public function resetFields()
    {
        $this->editMode = false;
        $this->productoId = null;
        $this->nombre = '';
        $this->descripcion = '';
        $this->stok = '';
        $this->precio_compra = '';
        $this->precio_venta = '';
    }

    public function loadProductDetails($id)
    {
        $producto = Producto::findOrFail($id);
        $this->productoId = $producto->id;
        $this->nombre = $producto->nombre;
        $this->descripcion = $producto->descripcion;
        $this->stok = (int) $producto->stok;
        $this->precio_compra = (float) $producto->precio_compra; // Convertir a float
        $this->precio_venta = (float) $producto->precio_venta;   // Convertir a float
         $this->fecha_creacion = Carbon::parse($producto->created_at)->format('d/m/Y');

        // Mostrar el modal de detalle
        $this->dispatchBrowserEvent('show-detail-modal');
    }
    public function checkLowStock()
    {
        // Definir el umbral de bajo stock (por ejemplo, 5 unidades)
        $lowStockProducts = Producto::where('stok', '<', 5)->get();
    
        if ($lowStockProducts->isNotEmpty()) {
            // Emitir evento para mostrar la alerta con productos
            $this->dispatchBrowserEvent('low-stock-alert', ['products' => $lowStockProducts]);
        } else {
            // Si no hay productos con bajo stock, muestra un mensaje de todo en orden
            $this->dispatchBrowserEvent('low-stock-alert', ['message' => 'Todos los productos tienen suficiente stock.']);
        }
    }
    

    
    public function render()
    {
        $this->hasLowStockProducts = Producto::where('stok', '<', 5)->exists(); 
        $productos = Producto::where('nombre', 'like', '%' . $this->search . '%')
        ->when($this->stockFilter, function ($query) {
            return $query->where('stok', '>=', $this->stockFilter);
        })
        ->when($this->lowStockFilter, function ($query) {
            return $query->where('stok', '<', 6); // Filtrar productos con stock bajo
        })
        ->paginate(5);


        return view('livewire.producto-table', [
            'productos' => $productos,
        ]);
    }
}
