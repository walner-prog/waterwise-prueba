<div>
    @can('ver-historial-pagos')
    <div class="container">
        <div class="mb-4 p-4 bg-gray-100 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Historial de Pagos - Cliente: {{ $cliente->primer_nombre }} {{ $cliente->primer_apellido }}</h2>
            <p class="text-sm text-gray-600 text-green">Número de teléfono: {{ $cliente->telefono }}</p>
            <p class="text-sm text-gray-600 text-green">Correo electrónico: {{ $cliente->email }}</p>
        </div>

        <!-- Barra de búsqueda y filtro de monto -->
        <div class="row mb-3">
            <div class="col-md-6">
                <input wire:model="search" type="text" class="form-control" placeholder="Buscar por monto...">
            </div>
            <div class="col-md-6">
                <input wire:model="filtroMonto" type="number" step="0.01" class="form-control" placeholder="Filtrar por monto mínimo...">
            </div>
        </div>

        @if($historialPagos->isNotEmpty())
        <table class="min-w-full w-full border w-100 border-gray-300 shadow-md rounded-lg p-2 table-striped table-bordered">
            <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
                <tr>
                    <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">ID</th>
                    <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">Fecha de Pago</th>
                    <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">Monto</th>
                    <th class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">Factura Asociada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historialPagos as $pago)
                <tr>
                    <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">{{ $pago->id }}</td>
                    <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">{{ $pago->fecha }}</td>
                    <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200">C${{ number_format($pago->monto, 2) }}</td>
                    <td class="px-6 py-3 p-1 text-left text-base font-medium tracking-wider border-b border-gray-200"><span class="badge badge-warning">#{{ $pago->factura->id }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $historialPagos->links() }}
        </div>
        @else
        <div class="p-4 border border-gray-300 rounded-lg text-center">
            <p class="text-dark">No hay historial de pagos para este cliente.</p>
        </div>
        @endif
    </div>
    @endcan
</div>
