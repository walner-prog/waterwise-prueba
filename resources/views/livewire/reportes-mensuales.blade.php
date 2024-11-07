<div>
    <h3 class="text-dark">Reportes Financieros Mensuales</h3>

    <div class="d-flex mb-3">
        <select class="form-control w-25 me-2" wire:model="searchAnio">
            <option value="">Seleccionar año...</option>
            @foreach($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>

        <select class="form-control w-25" wire:model="searchMes">
            <option value="">Seleccionar mes...</option>
            @foreach($months as $key => $month)
                <option value="{{ $key }}">{{ $month }}</option>
            @endforeach
        </select>
    </div>


    <table class="table table-striped table-bordered shadow-sm">
        <thead class="bg-primary text-white">
            <tr>
                <th>Nombre del Reporte</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportes as $reporte)
                <tr>
                    <td>{{ $reporte->nombre }}</td>
                    <td>{{ \Carbon\Carbon::parse($reporte->fecha)->format('d-m-Y') }}</td>

                    <td><a href="{{ route('reportes.show', $reporte->id) }}" target="_blank">Ver PDF</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No se encontraron reportes.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $reportes->links() }}
</div>
