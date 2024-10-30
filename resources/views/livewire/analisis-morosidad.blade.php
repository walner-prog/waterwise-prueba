<div class="">

    <div class="card p-1">
             
        <h3 class="text-dark mb-4">Análisis de Morosidad</h3>

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

    @if ($facturasMorosas->count() > 0)
    <table class="min-w-full w-full border w-100 border-gray-300 shadow-md rounded-lg p-2 table-striped table-bordered">
        <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
                <tr>
                    <th class=" text-muted p-1">Nombre <i class="fas fa-user text-muted"></i></th>
                    <th class=" text-muted p-1">Apellido <i class="fas fa-user-tag text-muted"></i></th>
                    <th class=" text-muted p-1">Mes de Mora <i class="fas fa-calendar-alt text-muted"></i></th>
                    <th class=" text-muted p-1">Total Facturas Morosas <i class="fas fa-file-invoice-dollar text-muted"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($facturasMorosas as $factura)
                    <tr>
                        <td class="p-1">{{ $factura->nombre_cliente }}</td>
                        <td class="p-1">{{ $factura->apellido_cliente }}</td>
                        <td class="p-1">{{ $factura->mes_mora }}</td>
                        <td class="p-1">
                            <span class="badge bg-danger">{{ $factura->total_facturas_morosas }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $facturasMorosas->links() }}

    @else
        <div class="alert alert-warning mt-3">
            No se encontraron facturas morosas para los criterios seleccionados.
        </div>
    @endif
    </div>
    
</div>
