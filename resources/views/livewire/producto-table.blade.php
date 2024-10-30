<div class="container">
   
   <div class="row mb-3">
       <div class="col-lg-4 mb-1">
         <input type="text" wire:model="search" class="form-control" placeholder="Buscar productos...">
       </div>

       <div class="col-lg-3 mb-1">
     
          <input type="number" id="filter-stock" class="form-control" wire:model="stockFilter" placeholder="Ingrese el stock mínimo">
      </div>

     
    

       <div class="col-lg-5 mb-1 d-flex justify-content-end">
            
          @can('crear-medidores')
            <button wire:click="openModal" class="btn btn-info">Agregar Producto</button>
          @endcan
       </div>
   </div>
   
   <div class="row">
    <div class="col-lg-6 mb-1">
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="low-stock-filter" wire:model="lowStockFilter">
            <label class="form-check-label" for="low-stock-filter">Mostrar solo productos con bajo stock</label>
        </div>
        
      </div>

      <div class="col-lg-6 mb-2 d-flex justify-content-end">
        @if($hasLowStockProducts)
        <button wire:click="checkLowStock" class="btn btn-warning text-white">
            Alerta de Stocks Bajos
        </button>
    @endif
        
      </div>
   </div>
       
    
<div class="table-responsive">
  <!-- Tabla de productos -->
  @if($productos->isNotEmpty())
  <table class="min-w-full w-full border w-100 border-gray-300 shadow-md rounded-lg p-2 table-striped border-bottom">
      <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
          <tr>
              <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">ID</th>
              <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">Nombre</th>
              <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">Descripción</th>
              <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">Stock</th>
              <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">Precio de Compra</th>
              <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">Precio de Venta</th>
              <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200" style="width: 270px">Acciones</th>
          </tr>
      </thead>
      <tbody>
          @foreach($productos as $producto)
              <tr class="">
                  <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">{{ $producto->id }}</td>
                  <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">{{ $producto->nombre }}</td>
                  <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">{{ $producto->descripcion }}</td>

                  <!-- Stock con color según la cantidad -->
                  <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">
                      <span class="badge 
                          @if($producto->stok < 6) badge-danger
                          @elseif($producto->stok <= 50) badge-warning
                          @else badge-success
                          @endif">
                          {{ $producto->stok }}
                      </span>
                  </td>

                  <!-- Precio de compra y venta con el símbolo de córdoba y color diferenciado -->
                  <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200 text-blue-600">C${{ number_format($producto->precio_compra, 2) }}</td>
                  <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200 text-green-600">C${{ number_format($producto->precio_venta, 2) }}</td>

                  <!-- Botones de acción con permisos -->
                  <td class=" p-1">
                      @can('ver-medidores')
                      <button class=" btn btn-purple btn-sm" wire:click="loadProductDetails({{ $producto->id }})">Ver</button>

                      @endcan
                      @can('editar-medidores')
                          <button wire:click="edit({{ $producto->id }})" class="btn btn-green btn-sm">Editar</button>
                      @endcan
                      @can('borrar-medidores')
                          <button wire:click="delete({{ $producto->id }})" class="btn btn-orange btn-sm">Eliminar</button>
                      @endcan
                  </td>
              </tr>
              
          @endforeach
      </tbody>
  </table>

  <div class="mt-4">
      {{ $productos->links() }}
  </div>
@else
  <div class="p-4 border border-gray-300 rounded-lg text-center">
      <p class="text-dark">No hay productos disponibles.</p>
  </div>
@endif
</div>
   

    @if($modalOpen)
        <div class="modal d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editMode ? 'Editar Producto' : 'Agregar Producto' }}</h5>
                        <button type="button" class="close" wire:click="$set('modalOpen', false)" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <!-- Campos con íconos -->
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" wire:model="nombre" class="form-control" placeholder="Nombre del producto">
                                @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Descripción</label>
                                <input type="text" wire:model="descripcion" class="form-control" placeholder="Descripción del producto">
                                @error('descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" wire:model="stok" class="form-control" placeholder="Cantidad en stock">
                                @error('stok') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Precio de Compra</label>
                                <input type="number" step="0.01" wire:model="precio_compra" class="form-control" placeholder="Precio de compra">
                                @error('precio_compra') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Precio de Venta</label>
                                <input type="number" step="0.01" wire:model="precio_venta" class="form-control" placeholder="Precio de venta">
                                @error('precio_venta') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" wire:click="$set('modalOpen', false)" class="btn btn-secondary">Cerrar</button>
                            <button type="submit" class="btn btn-primary">{{ $editMode ? 'Actualizar' : 'Guardar' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

   <!-- Modal de Detalle del Producto -->
<div class="modal fade" id="detalleProductoModal" tabindex="-1" aria-labelledby="detalleProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalleProductoModalLabel">Detalles del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong>ID:</strong> <span>{{ $productoId }}</span><br>
                <strong>Nombre:</strong> <span>{{ $nombre }}</span><br>
                <strong>Descripción:</strong> <span>{{ $descripcion }}</span><br>
                <strong>Stock:</strong> <span>{{ $stok }}</span><br>
                 {{--  
                     <strong>Precio de Compra:</strong> <span>C${{ number_format($precio_compra, 2) }}</span><br>
                     <strong>Precio de Venta:</strong> <span>C${{ number_format($precio_venta, 2) }}</span><br>
                 --}} 
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

   
</div>
