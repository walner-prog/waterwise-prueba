<div>
    <h3 class="text-dark">Total de Ingresos por Cliente</h3>
    <input type="text" class="form-control w-25 mt-2 mb-3" wire:model="search" placeholder="Buscar cliente..." />

    <table class="min-w-full w-full border w-100 border-gray-300 shadow-md rounded-lg p-2 table-striped table-bordered">
        <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
            <tr>
                <th>Factura ID</th>
                <th>Nombres del Cliente</th>
                <th>Mes Leído</th>
                <th>Total Ingresos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ingresosPorCliente as $ingreso)
                <tr>
                    <td>{{ $ingreso->factura_id }}</td>
                    <td>
                        @if($ingreso->factura && $ingreso->factura->cliente)
                            {{ $ingreso->factura->cliente->primer_nombre . ' ' . $ingreso->factura->cliente->primer_apellido }}
                        @else
                            Sin nombre
                        @endif
                    </td>
                    <td>
                        @if($ingreso->factura && $ingreso->factura->lecturaMensual)
                            {{ $ingreso->factura->lecturaMensual->mes_leido }} <!-- Mostrar mes leído -->
                        @else
                            Sin mes leído
                        @endif
                    </td>
                    <td>
                        @php
                            // Definir el color del badge basado en el total de ingresos
                            $badgeClass = $ingreso->total_ingresos > 300 ? 'bg-success' : ($ingreso->total_ingresos > 150 ? 'bg-warning' : 'bg-danger');
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            {{ $ingreso->total_ingresos }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $ingresosPorCliente->links() }} <!-- Paginación -->
</div>
