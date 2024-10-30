<div>
    <h3 class="text-dark">Total de Ingresos Mensuales</h3>

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
    @if ($ingresosMensuales->count() > 0)
    <table class="min-w-full w-full border border-gray-300 w-100 shadow-md rounded-lg p-2 table-striped table-bordered">
            <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
                <tr>
                    <th>Año</th>
                    <th>Mes</th>
                    <th>Total Ingresos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ingresosMensuales as $ingreso)
                    <tr>
                        <td>{{ $ingreso->anio }}</td>
                        <td>{{ \Carbon\Carbon::create()->month($ingreso->mes)->translatedFormat('F') }}</td> <!-- Mostrar mes en español -->
                        <td>
                            @php
                                // Definir el color del badge basado en el total de ingresos
                                $badgeClass = $ingreso->total_ingresos > 20000 ? 'bg-success' : ($ingreso->total_ingresos > 10000 ? 'bg-warning' : 'bg-danger');
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ $ingreso->total_ingresos }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $ingresosMensuales->links() }} <!-- Paginación -->
    
    @else
        <!-- Mostrar un mensaje si no hay resultados para los filtros -->
        <div class="alert alert-warning mt-3">
            No se encontraron ingresos para los criterios seleccionados.
        </div>
    @endif
</div>
