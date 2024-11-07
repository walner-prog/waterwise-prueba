<!DOCTYPE html>
<html lang="en">
    <head>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
    
    @section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css">
     
      @livewireStyles
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
  
  @stop
      <!-- Otros elementos del encabezado... -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <head>
        <script>
          (function() {
            const currentTheme = localStorage.getItem('theme');
            if (currentTheme === 'dark') {
              document.documentElement.classList.add('dark-mode');
              document.documentElement.classList.remove('light-mode');
            } else if (currentTheme === 'light') {
              document.documentElement.classList.add('light-mode');
              document.documentElement.classList.remove('dark-mode');
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
              document.documentElement.classList.add('dark-mode');
            } else {
              document.documentElement.classList.add('light-mode');
            }
          })();
        </script>
        <!-- Resto de tu <head> -->
      </head>
  </head>
<body>
    @extends('adminlte::page')

   @section('title', 'detalle  cliente')





   @section('content')
   <div class="container mt-4 toggle-container">
   
       @section('preloader')
           <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
       @stop
       
       <!-- Breadcrumb de navegación -->
       <div class="row">
           <div class="col">
               <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                   <ol id="breadcrumb" class="breadcrumb mb-0 text-light">
                       <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
                       <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
                       <li class="breadcrumb-item active" aria-current="page">Detalle del Cliente</li>
                   </ol>
               </nav>
           </div>
       </div>
       
       <!-- Detalle del Cliente -->
       <div class="row">
           <div class="col-lg-6 mb-4">
               <div class="card shadow-sm">
                   <div class="card-header bg-primary text-white">
                       <h5 class="mb-0">Información del Cliente</h5>
                   </div>
                   <div class="card-body text-muted">
                       <p class="text-muted"><strong>Nombre:</strong> {{ $cliente->primer_nombre }} {{ $cliente->primer_apellido }}</p>
                       <p class="text-muted"><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
                       <p class="text-muted"><strong>Email:</strong> {{ $cliente->email }}</p>
                       <p class="text-muted"><strong>Dirección:</strong> {{ $cliente->direccion }}</p>
                       <p class="text-muted"><strong>Fecha de Registro:</strong> {{ $cliente->fecha_registro }}</p>

                   </div>
               </div>
           </div>
   
           <!-- Opcional: Historial de Pagos u otros detalles relacionados -->
           <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Historial de los ultimos 3  Pagos</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($facturas as $factura)
                            <li class="list-group-item">
                                <strong class="  text-white bg-secondary p-1">Fecha de Pago:</strong> <p class="text-muted">{{ \Carbon\Carbon::parse($factura->fecha_pago)->format('d/m/Y') }}</p>
                                <p class="text-muted"><strong>Monto:</strong> ${{ $factura->monto_formateado }}</p>
                            </li>
                        @empty
                            <li class="list-group-item">No hay pagos registrados</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        
       </div>
       
       <!-- Botones de Acción -->
       <div class="row">
           <div class="col">
               <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-success">
                   <i class="fas fa-edit"></i> Editar Cliente
               </a>
               <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                   <i class="fas fa-arrow-left"></i> Volver a la lista
               </a>
           </div>
       </div>
   </div>
   @stop
   

@section('css')


    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@livewireScripts
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>


<!-- JS de DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




@stop
    
</body>
</html>

