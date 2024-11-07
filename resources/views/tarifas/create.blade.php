<!DOCTYPE html>
<html lang="en">
    <head>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
    
    @section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
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

@section('title', 'Crear tarifa')



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
                    <li class="breadcrumb-item " aria-current="page">Registros de tarifas</li>
                    <li class="breadcrumb-item active" aria-current="page"> Crear nueva tarifa </li>
                </ol>
            </nav>
        </div>
    </div>
    
  

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('info'))
    <div class="alert alert-success">{{ session('info') }}</div>
    @endif
    @if (session('delete'))
    <div class="alert alert-warning">{{ session('delete') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

         @can('crear-tarifas')
        
            
         <p class=" btn btn-danger text-white" data-toggle="tooltip" data-placement="top" title="Si ya tienes una tarifa en vigencia y creas una nueva, esta última entrará en vigencia y todas las facturas se regirán bajo la tarifa vigente."><i class="fas fa-info-circle" ></i>Atencion</p>   
          
           
        
         <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header card-indigo">
                <h3 class="text-center font-weight-light my-2 h3-text text-white">
                    <i class="fa-solid fa-tag fa-2x mr-2"></i>
                    @if(isset($tarifa))
                        Editar Tarifa
                    @else
                        Registrar Tarifa
                    @endif
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($tarifa) ? route('tarifas.update', $tarifa->id) : route('tarifas.store') }}" method="POST" class=" needs-validation" novalidate>
                    @csrf
                    @if(isset($tarifa))
                        @method('PUT')
                    @endif
                    <div class="row">
                        <!-- Tipo de Tarifa -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tipo_tarifa" class="bold">
                                    <i class="fa-solid fa-tag"></i> Tipo de Tarifa <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="tipo_tarifa" name="tipo_tarifa" value="{{ old('tipo_tarifa', $tarifa->tipo_tarifa ?? '') }}" required>
                                @if ($errors->has('tipo_tarifa'))
                                    <div class="text-danger">{{ $errors->first('tipo_tarifa') }}</div>
                                @endif
                            </div>
                        </div>
            
                        <!-- Precio por m³ -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="precio_por_m3" class="bold">
                                    <i class="fa-solid fa-dollar-sign"></i> Precio por m³ <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="precio_por_m3" name="precio_por_m3" 
                                       value="{{ old('precio_por_m3', $tarifa->precio_por_m3 ?? '') }}" 
                                       placeholder="Ingrese el precio por m³" required>
                                <div class="invalid-feedback">Por favor, ingrese un precio válido (hasta 3 dígitos enteros y 2 decimales).</div>
                                @if ($errors->has('precio_por_m3'))
                                    <div class="text-danger">{{ $errors->first('precio_por_m3') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
            
                    <div class="row">
                        <!-- Descripción -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="descripcion" class="bold">
                                    <i class="fa-solid fa-info-circle"></i> Descripción
                                </label>
                                <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion', $tarifa->descripcion ?? '') }}</textarea>
                                @if ($errors->has('descripcion'))
                                    <div class="text-danger">{{ $errors->first('descripcion') }}</div>
                                @endif
                            </div>
                        </div>
            
                        <!-- Fecha de Vigencia -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="fecha_vigencia" class="bold">
                                    <i class="fa-solid fa-calendar-alt"></i> Fecha de Vigencia <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="fecha_vigencia" name="fecha_vigencia" value="{{ old('fecha_vigencia', $tarifa->fecha_vigencia ?? '') }}" required>
                                @if ($errors->has('fecha_vigencia'))
                                    <div class="text-danger">{{ $errors->first('fecha_vigencia') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-indigo">
                            <i class="fa-solid fa-save"></i> @if(isset($tarifa)) Actualizar Tarifa @else Guardar Tarifa @endif
                        </button>
                    </div>
                </form>
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
<scr'
ipt src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Inicializar tooltip
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>


<script>
    // Limitar a 3 dígitos enteros y hasta 2 decimales en el campo 'precio_por_m3'
    document.getElementById('precio_por_m3').addEventListener('input', function (e) {
        let value = this.value;

        // Permite solo 3 dígitos enteros y hasta 2 decimales
        if (!/^\d{0,3}(\.\d{0,2})?$/.test(value)) {
            this.value = value.slice(0, -1);
        }
    });

    // Validación de Bootstrap
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

@stop
    
</body>
</html>

