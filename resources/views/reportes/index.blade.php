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

@section('title', 'repoortes')




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
                    <li class="breadcrumb-item active" aria-current="page">Reportes</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
       
        <div class="col-lg-2">
           
        </div>
 
    
   
        
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="container card p-2">
                <h3 class=" text-dark">Consumo Promedio por Cliente</h3>
                <table id="" class="min-w-full w-full w-100 border border-gray-300 shadow-md rounded-lg p-2">
                    <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
                        <tr>
                            <th class=" p-1">ID Cliente</th>
                            <th class=" p-1">Nombres del  Cliente</th>
                            <th class=" p-1">Consumo Promedio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consumoPromedio as $consumo)
                        <tr>
                            <td class=" p-1">{{ $consumo->cliente_id }}</td>
                            <td class=" p-1">{{ $consumo->cliente ? $consumo->cliente->primer_nombre . ' ' .  $consumo->cliente->primer_apellido : 'sin registros' }}</td>
                            <td class=" p-1">{{ number_format($consumo->consumo_promedio, 2) }} m³</td>
                        </tr>
                    @endforeach
                
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="container card p-2">
                <h3 class=" text-dark">Total de Lecturas por Cliente</h3>
                <table id="" class="min-w-full w-full w-100 border border-gray-300 shadow-md rounded-lg p-2">
                    <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
                        <tr class=" ">
                            <th class=" p-1">ID Cliente</th>
                            <th class=" p-1">Nombres del  Cliente</th>
                            <th class=" p-1">Total de Lecturas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($totalLecturas as $lectura)
                            <tr>
                                <td class=" p-1">{{ $lectura->cliente_id }}</td>
                                <td class=" p-1">{{ $lectura->cliente ? $lectura->cliente->primer_nombre . ' ' .  $lectura->cliente->primer_apellido : 'sin registros' }}</td>
                                <td class=" p-1">{{ $lectura->total_lecturas }}</td>
                            </tr>
                        @endforeach
                    
                </table>
            </div>
        </div>
       
         <div class="col-lg-6 mb-3 mt-4">
              <div class="card p-1">
                @livewire('ingresos-por-cliente')
            </div>
        </div>
      
            <div class="col-lg-6 mb-3 mt-4">
                <div class="card p-1">     
                @livewire('ingresos-mensuales')
              </div>
        </div>
    
            
        <div class="col-lg-6 mb-3 mt-4">
          
            <div class="card p-1">
                @livewire('relacion-ingresos-facturacion')
            </div>
           
        </div>
        
       
       
        
        <div class="col-lg-6 mb-3 mt-4">
            <div class="card p-1">
                @livewire('analisis-morosidad')
            </div>
          
        </div>
       
        <div class="col-lg-12 mb-3 mt-4">
            <div class="card p-1">
                @livewire('facturas-por-cliente')
            </div>
           
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


<script>



</script>

@stop
    
</body>
</html>

