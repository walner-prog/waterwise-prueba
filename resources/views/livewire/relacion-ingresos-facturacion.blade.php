<div>

  
     
            <h3 class="text-dark">Relación entre Ingresos y Facturación</h3>

        <div class="row mb-3">
            <div class="col-lg-6">
                <!-- Búsqueda por año -->
                <input type="number" class="form-control w-100" wire:model="searchAnio" placeholder="Buscar por año..." />
            </div>
            <div class="col-lg-6">
                <!-- Búsqueda por mes -->
                <select class="form-control w-100" wire:model="searchMes">
                    <option value="">Seleccionar mes</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                    @endfor
                </select>
            </div>
      
    
        </div>
        
        <!-- Verificar si hay registros -->
@if ($comparativaFacturacionIngresos->count() > 0)
<table class="min-w-full w-full w-100 border border-gray-300 shadow-md rounded-lg p-2 table-striped table-bordered">
    <thead class="bg-gradient-to-r from-green-500 to-green-600 text-white w-full">
        <tr>
            <th>Cliente</th>
            <th>Total Facturado</th>
            <th>Total Ingresos</th>
            <th>Diferencia</th>
        </tr>
    </thead>
    <tbody>
        @foreach($comparativaFacturacionIngresos as $item)
            <tr>
                <td>{{ $item->cliente->primer_nombre }} {{ $item->cliente->primer_apellido }}</td>
                <td>
                    @php
                        // Definir el color del badge para Total Facturado
                        $facturadoBadgeClass = $item->total_facturado > 500 ? 'bg-success' : ($item->total_facturado > 250 ? 'bg-warning' : 'bg-danger');
                    @endphp
                    <span class="badge {{ $facturadoBadgeClass }}">
                        {{ $item->total_facturado }}
                    </span>
                </td>
                <td>
                    @php
                        // Definir el color del badge para Total Ingresos
                        $ingresosBadgeClass = $item->total_ingresos > 1000 ? 'bg-success' : ($item->total_ingresos > 500 ? 'bg-warning' : 'bg-danger');
                    @endphp
                    <span class="badge {{ $ingresosBadgeClass }}">
                        {{ $item->total_ingresos }}
                    </span>
                </td>
                <td>
                    @php
                        $diferencia = $item->total_facturado - $item->total_ingresos;
                    @endphp
                    <span class="{{ $diferencia > 0 ? 'text-danger' : 'text-success' }}">
                        {{ $diferencia > 0 ? 'Discrepancia de ' . $diferencia : 'Sin discrepancia' }}
                    </span>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-2">
    {{ $comparativaFacturacionIngresos->links() }} <!-- Paginación -->
</div>

@else
    <!-- Mostrar un mensaje si no hay resultados -->
    <div class="alert alert-warning mt-3">
        No se encontraron registros para los criterios seleccionados.
    </div>
@endif

    
</div>
