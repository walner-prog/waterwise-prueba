<div class="container">
    <div class="row mb-3">
        <div class="col-lg-4 mb-1">
            <input type="text" wire:model="search" class="form-control" placeholder="Buscar ventas...">
        </div>

        <div class="col-lg-5 mb-1 d-flex justify-content-end">
            @can('crear-medidores')
                <button wire:click="openModal" class="btn btn-info">Agregar Venta</button>
            @endcan
        </div>
    </div>

    <div class="table-responsive">
        <!-- Tabla de ventas -->
        @if($ventas->isNotEmpty())
            <table class="min-w-full w-full border w-100 border-gray-300 shadow-md rounded-lg p-2 table-striped border-bottom">
                <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
                    <tr>
                        <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">ID</th>
                        <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">Producto</th>
                        <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">Cantidad</th>
                        <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">Precio de Venta</th>
                        <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">Total a Pagar</th>
                        <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200" style="width: 270px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                        <tr>
                            <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">{{ $venta->id }}</td>
                            <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">{{ $venta->producto->nombre }}</td>
                            <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">{{ $venta->cantidad }}</td>
                            <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200 text-green-600">C${{ number_format($venta->precio_venta, 2) }}</td>
                            <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200 text-blue-600">C${{ number_format($venta->total_pagar, 2) }}</td>
                            <td class="p-1">
                                @can('ver-medidores')
                                    <button class="btn btn-purple btn-sm" wire:click="loadVentaDetails({{ $venta->id }})">Ver</button>
                                @endcan
                                @can('editar-medidores')
                                    <button wire:click="edit({{ $venta->id }})" class="btn btn-green btn-sm">Editar</button>
                                @endcan
                                @can('borrar-medidores')
                                    <button wire:click="delete({{ $venta->id }})" class="btn btn-orange btn-sm">Eliminar</button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $ventas->links() }}
            </div>
        @else
            <div class="p-4 border border-gray-300 rounded-lg text-center">
                <p class="text-dark">No hay ventas disponibles.</p>
            </div>
        @endif
    </div>

    @if($modalOpen)
        <div class="modal d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editMode ? 'Editar Venta' : 'Agregar Venta' }}</h5>
                        <button type="button" class="close" wire:click="$set('modalOpen', false)" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Producto</label>
                                <select wire:model="producto_id" class="form-control select2" id="select-producto">
                                    <option value="">Selecciona un producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('producto_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                           
                            
                            <div class="form-group">
                                <label>Cliente</label>
                                <select wire:model="cliente_id" class="form-control select2" id="select2">
                                    <option value="">Selecciona un cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">
                                            {{ $cliente->primer_nombre }} {{ $cliente->primer_apellido }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cliente_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            
                            
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" wire:model="cantidad" class="form-control" placeholder="Cantidad vendida">
                                @error('cantidad') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Precio de Venta</label>
                                <input type="number" step="0.01" wire:model="precio_venta" class="form-control" placeholder="Precio de venta">
                                @error('precio_venta') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Total a Pagar</label>
                                <input type="number" step="0.01" wire:model="total_pagar" class="form-control" placeholder="Total a pagar" readonly>
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

   
</div>
