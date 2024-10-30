<div>
    <h3 class="text-dark">Total de Ingresos y Egresos Mensuales</h3>

    <div class="row mb-3">
        <div class="col-lg-6">
            <input type="number" class="form-control" wire:model="searchAnio" placeholder="Buscar por año..." />
        </div>
        <div class="col-lg-6">
            <select class="form-control" wire:model="searchMes">
                <option value="">Seleccionar mes</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                @endfor
            </select>
        </div>
    </div>

    @if ($ingresosEgresos->count() > 0)
    <table class="min-w-full w-100 border border-gray-300 shadow-md rounded-lg p-2 table-striped table-bordered">
        <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
            <tr>
                <th class="text-indigo-600">Año</th>
                <th class="text-indigo-600">Mes</th>
                <th class="text-indigo-600">Total Ingresos</th>
                <th class="text-indigo-600">Total Egresos</th>
                <th class="text-indigo-600">Diferencia</th>
                <th class="text-indigo-600">Saldo Acumulado</th>
            </tr>
        </thead>
        <tbody>
            @php
                $saldoAcumulado = 0;
            @endphp
            @foreach($ingresosEgresos as $item)
                @php
                    $diferencia = $item->total_ingresos - $item->total_egresos;
                    $saldoAcumulado += $diferencia;
                    $badgeClassDiferencia = $diferencia >= 0 ? 'bg-success' : 'bg-danger';
                    $badgeClassSaldo = $saldoAcumulado >= 0 ? 'bg-primary' : 'bg-danger';
                @endphp
                <tr>
                    <td>{{ $item->anio }}</td>
                    <td>{{ \Carbon\Carbon::create()->month($item->mes)->translatedFormat('F') }}</td>
                    <td class="text-primary">{{ $item->total_ingresos }}</td>
                    <td class="text-primary">{{ $item->total_egresos }}</td>
                    <td>
                        <span class="badge {{ $badgeClassDiferencia }}">
                            {{ $diferencia }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $badgeClassSaldo }}">
                            {{ $saldoAcumulado }}
                        </span>
                        @if ($saldoAcumulado < 0)
                            <div class="text-danger">¡Saldo negativo!</div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $ingresosEgresos->links() }}
    
@else
    <div class="alert alert-warning mt-3">
        No se encontraron registros para los criterios seleccionados.
    </div>
@endif

</div>
