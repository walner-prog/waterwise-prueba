<!-- resources/views/livewire/consumo-mensual.blade.php -->

<div>
    <h3 class="text-dark">Total de Consumo Mensual</h3>

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

    <!-- Verificar si hay registros según la búsqueda -->
    @if ($consumosMensuales->count() > 0)
        <table class="min-w-full w-full w-100 border border-gray-300 shadow-md rounded-lg p-2 table-striped table-bordered">
            <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
                <tr>
                    <th>Año</th>
                    <th>Mes</th>
                    <th>Total Consumo (m³)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consumosMensuales as $consumo)
                    <tr>
                        <td>{{ $consumo->anio }}</td>
                        <td>{{ \Carbon\Carbon::create()->month($consumo->mes)->translatedFormat('F') }}</td>
                        <td>{{ $consumo->total_consumo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    
    @else
        <div class="alert alert-warning mt-3">
            No se encontraron consumos para los criterios seleccionados.
        </div>
    @endif
    {{ $consumosMensuales->links() }} <!-- Paginación -->
</div>
