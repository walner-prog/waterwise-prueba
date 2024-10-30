<div>
     <h3 class=" text-dark">Clientes Morosos y Facturas Pendientes</h3>
        <!-- Barra de búsqueda -->
        <div class="row mb-4">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Buscar por nombre" wire:model="search">
            </div>
            <div class="col-lg-4">
                <select class="form-control" wire:model="mes">
                    <option class=" text-muted" value="">Seleccionar mes</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Año (YYYY)" wire:model="anio">
            </div>
        </div>
    
        <!-- Tabla de medidores con deuda -->
        @if ($medidoresConDeuda->isNotEmpty())
        <table class="min-w-full w-100 border border-gray-300 shadow-md rounded-lg p-2 table-striped table-bordered">
            <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
                    <tr>
                        <th>Medidor</th>
                        <th>Cliente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medidoresConDeuda as $medidor)
                        <tr>
                            <td>{{ $medidor->id }}</td>
                            <td>{{ $medidor->cliente->primer_nombre }} {{ $medidor->cliente->segundo_nombre }} 
                                {{ $medidor->cliente->primer_apellido }}   {{ $medidor->cliente->segundo_apellido }}</td>
                            <td>
                                @if ($medidor->facturas->isNotEmpty())
                                <a href="{{ route('recibo.cobro.pdf', $medidor->cliente_id) }}" class="btn btn-primary" target="_blank">
                                    <i class="fas fa-print"></i> Imprimir Recibo
                                </a>
                                
                                <a href="{{ route('enviar.recibo.whatsapp', $medidor->cliente_id) }}" class="btn btn-success">
                                    <i class="fab fa-whatsapp"></i> Enviar por WhatsApp
                                </a>
                                
                                <a href="{{ route('enviar.recibo.correo', $medidor->cliente_id) }}" class="btn btn-danger text-white">
                                    <i class="fas fa-envelope"></i> Enviar por Correo
                                </a>
                                
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Paginación -->
            <div class="d-flex justify-content-center">
                {{ $medidoresConDeuda->links() }}
            </div>
        @else
            <div class="alert alert-warning mt-3">
                No hay clientes con facturas pendientes en este momento para este mes.
            </div>
        @endif
    
    

</div>
