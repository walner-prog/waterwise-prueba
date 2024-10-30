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

@section('title', 'detalle ingreso')



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
                  <li class="breadcrumb-item active" aria-current="page">Detalles de Ingresos</li>
              </ol>
          </nav>
      </div>
  </div>

  @can('ver-ingresos')
  <div class="container mt-5">
    <h1 class="text-dark">Detalles del Ingreso ID: {{ $ingreso->id }}</h1>
  
    <!-- Botón para cambiar tamaño de fuente -->
    <button id="toggleFontSize" class="btn btn-secondary mb-3">Agrandar Texto</button>

    <!-- Información básica del ingreso -->
    <div class="card mb-3" id="ingresoDetails">
        <div class="card-body">
            <p class="text-muted"><strong>Ingreso ID:</strong> {{ $ingreso->id }}</p>
            
            <!-- Condicionar para mostrar el ID de la factura o de la venta -->
            @if ($ingreso->factura)
                <p class="text-muted"><strong>Factura ID:</strong> {{ $ingreso->factura->id }}</p>
                
                <!-- Mostrar información de la lectura -->
                @if ($ingreso->factura->lectura)
                    <p class="text-muted"><strong>Lectura Anterior:</strong> {{ $ingreso->factura->lectura->lectura_anterior }}</p>
                    <p class="text-muted"><strong>Lectura Actual:</strong> {{ $ingreso->factura->lectura->lectura_actual }}</p>
                    <p class="text-muted"><strong>Fecha de Lectura:</strong> {{ \Carbon\Carbon::parse($ingreso->factura->lectura->fecha_lectura)->format('d/m/Y') }}</p>
                    <p class="text-muted"><strong>Consumo:</strong> {{ $ingreso->factura->lectura->consumo }}</p>
                @endif
              @elseif ($ingreso->venta)
                <p class="text-muted"><strong>Venta ID:</strong> {{ $ingreso->venta->id }}</p>
                
                @if ($ingreso->venta->productos && $ingreso->venta->productos->isNotEmpty())
                   <h3>Productos de la Venta:</h3>
                  <ul>
                         @foreach ($ingreso->venta->productos as $producto)
                           <li>{{ $producto->nombre }} - Cantidad: {{ number_format($producto->pivot->cantidad, 2) }} (C$ {{ number_format($producto->pivot->precio_venta, 2) }})</li>
                         @endforeach
                  </ul>
              @else
                       <p>No hay productos asociados a esta venta.</p>
              @endif

             @else
                <p class="text-muted"><strong>Factura / Venta ID:</strong> N/A</p>
            @endif
            
            <p class="text-muted"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($ingreso->fecha)->format('d/m/Y') }}</p>
            <p class="text-muted"><strong>Monto:</strong> C$ {{ number_format($ingreso->monto, 2) }}</p>
            <p class="text-muted"><strong>Descripción:</strong> {{ $ingreso->descripcion }}</p>
        </div>
    </div>
  
    <!-- Puedes agregar más información relacionada aquí -->
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
  document.addEventListener('DOMContentLoaded', function () {
      const toggleFontSizeButton = document.getElementById('toggleFontSize');
      const ingresoDetails = document.getElementById('ingresoDetails');
      let isLargeFont = false;

      toggleFontSizeButton.addEventListener('click', function () {
          if (isLargeFont) {
              ingresoDetails.style.fontSize = '1em'; // Tamaño de fuente normal
              toggleFontSizeButton.textContent = 'Agrandar Texto';
          } else {
              ingresoDetails.style.fontSize = '1.4em'; // Tamaño de fuente grande
              toggleFontSizeButton.textContent = 'Reducir Texto';
          }
          isLargeFont = !isLargeFont;
      });
  });
</script>


@stop
    
</body>
</html>

