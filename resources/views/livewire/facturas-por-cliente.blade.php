<div>
    <h3 class="text-dark">Facturas Pagadas y Pendientes por Cliente</h3>

    <div class="row mb-3">
        <div class="col-lg-4">
            <!-- Búsqueda por nombre de cliente -->
            <input type="text" class="form-control w-100" wire:model="search" placeholder="Buscar cliente..." />
        </div>
    </div>
    @if ($facturasPorCliente->count() > 0)
    <table class="min-w-full w-100 border border-gray-300 shadow-md rounded-lg p-2 table-striped table-bordered">
        <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
            <tr>
                <th>Cliente</th>
                <th>Total Facturas Emitidas</th>
                <th>Total Facturas Pagadas</th>
                <th>Facturas Pendientes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facturasPorCliente as $factura)
                @php
                    // Calcular facturas pendientes
                    $facturasPendientes = $factura->total_facturas - $factura->total_facturas_pagadas;
                    // Definir el color del badge para las facturas pendientes
                    $pendientesBadgeClass = $facturasPendientes > 1 ? 'bg-danger' : ($facturasPendientes > 0 ? 'bg-warning' : 'bg-success');
                @endphp
                <tr>
                    <td>{{ $factura->cliente->primer_nombre }} {{ $factura->cliente->primer_apellido }}</td>
                    <td>
                        <span class="badge bg-primary">
                            {{ $factura->total_facturas }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-success">
                            {{ $factura->total_facturas_pagadas }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $pendientesBadgeClass }}">
                            {{ $facturasPendientes }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $facturasPorCliente->links() }} <!-- Paginación -->
    
    @else
        <div class="alert alert-warning mt-3">
            No se encontraron registros para los criterios de búsqueda seleccionados.
        </div>
    @endif
    
</div>
