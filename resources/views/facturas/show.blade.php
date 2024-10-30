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

@section('title', 'detalle Facturas')




@section('content')
<div class="container mt-4 toggle-container">
    @section('preloader')
      <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    @stop
    
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                <ol id="breadcrumb" class="breadcrumb mb-0 text-light">
                    <li class="breadcrumb-item">Hogar</li>
                    <li class="breadcrumb-item active" aria-current="page">Detalles  de Factura </li>
                </ol>
            </nav>
        </div>
    </div>
    

    @can('ver-facturas')
    <div class="container mt-5">
        <h1 class="text-dark mb-4"><i class="fas fa-file-invoice-dollar"></i> Detalles de la Factura</h1>
    
        <!-- Información básica de la factura -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fas fa-receipt"></i> Factura No: {{ $factura->id }}</h5>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p class="text-muted"><strong>Cliente:</strong> 
                            {{ $factura->cliente->primer_nombre }} {{ $factura->cliente->primer_apellido }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted"><strong>Fecha de Emisión:</strong> 
                            {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted"><strong>Método de Pago:</strong> {{ $factura->metodo_pago }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted"><strong>Total:</strong> <span class="badge bg-success">C$ {{ number_format($factura->monto_total, 2) }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Información del medidor -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fas fa-tachometer-alt"></i> Medidor</h5>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p class="text-muted"><strong>Número de Medidor:</strong> {{ $factura->lectura->medidor->numero_medidor }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted"><strong>Ubicación del Medidor:</strong> {{ $factura->lectura->medidor->ubicacion }}</p>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Detalles de la lectura mensual -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fas fa-calendar-alt"></i> Lectura Mensual</h5>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <p class="text-muted"><strong>Mes Leído:</strong> {{ $factura->lectura->mes_leido }}</p>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted"><strong>Lectura Anterior:</strong> {{ $factura->lectura->lectura_anterior }} m³</p>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted"><strong>Lectura Actual:</strong> {{ $factura->lectura->lectura_actual }} m³</p>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted"><strong>Consumo:</strong> {{ $factura->lectura->consumo }} m³</p>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Información de la tarifa -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fas fa-money-bill-wave"></i> Tarifa</h5>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p class="text-muted"><strong>Descripción:</strong> {{ $factura->tarifa->descripcion }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted"><strong>Precio por m³:</strong> C$ {{ number_format($factura->tarifa->precio_por_m3, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Estado de Pago y Acción -->
        <div class="row mb-3">
            <div class="col-lg-6">
                @if ($factura->estado_pago === 'pagado')
                    <h4 class="text-success"><i class="fas fa-check-circle"></i> Total Pagado: C$ {{ number_format($factura->monto_total, 2) }}</h4>
                @else
                    <h4 class="text-danger"><i class="fas fa-exclamation-circle"></i> Estado de Pago: <strong>Pendiente.</strong></h4>
                    <h5 class="text-dark">Total a Pagar: C$ {{ number_format($factura->monto_total, 2) }}</h5>
                @endif
            </div>
            <div class="col-lg-6 text-lg-right">
                @if($factura->estado_pago === 'pendiente')
                    <a href="{{ route('factura.pendiente', $factura->cliente_id) }}" class="btn btn-info text-white">
                        <i class="fas fa-file-invoice"></i> Ver Facturas Pendientes
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    
    @endcan
   
    
  
</div>
@stop
@section('css')


    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>


<!-- JS de DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- CDN de Buttons para DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>

</script>


@stop
    
</body>
</html>

