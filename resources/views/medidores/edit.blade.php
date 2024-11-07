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

@section('title', 'editar Medidor')





@section('content')
<div class="container mt-4 toggle-container">
    @section('preloader')
      <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
     
   @stop
    
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                <ol id="breadcrumb" class="breadcrumb mb-0  text-light">
                    <li class="breadcrumb-item">Hogar</li>
                    <li class="breadcrumb-item active" aria-current="page">Editar  Medidor</li>
                </ol>
            </nav>
        </div>
    </div>
     <div class="row">
        
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


     @can('editar-medidores')
     <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header card-indigo ">
            <h3 class="text-center font-weight-light my-2 h3-text text-white">
                <i class="fa-solid fa-water fa-2x mr-2"></i>
                Editar Medidor
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('medidores.update', $medidor->id) }}" method="POST" class=" needs-validation" novalidate>
                @csrf
                @method('PUT') <!-- Este método es necesario para indicar que se está haciendo una actualización -->
                <div class="row">
                    <!-- Número de Medidor -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="numero_medidor" class="bold">
                                <i class="fa-solid fa-hashtag"></i> Número de Medidor <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="numero_medidor" name="numero_medidor" 
                                value="{{ old('numero_medidor', $medidor->numero_medidor) }}" 
                                placeholder="Ingrese el número único de medidor aquí" required pattern="^[0-9]{6,}$" 
                                inputmode="numeric" maxlength="10" required>
                                <div class="invalid-feedback">El número de medidor debe tener al menos 6 dígitos y no ser negativo.</div>
                            <div class="valid-feedback">Número de medidor válido.</div>
                            @if ($errors->has('numero_medidor'))
                                <div class="text-danger">{{ $errors->first('numero_medidor') }}</div>
                            @endif
                        </div>
                    </div>
            
                    <!-- Ubicación -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="ubicacion" class="bold">
                                <i class="fa-solid fa-map-marker-alt"></i> Ubicación <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" 
                                value="{{ old('ubicacion', $medidor->ubicacion) }}" required>
                            @if ($errors->has('ubicacion'))
                                <div class="text-danger">{{ $errors->first('ubicacion') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <!-- Información del Cliente -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cliente_id" class="bold">
                                <i class="fa-solid fa-id-card"></i> Cliente Seleccionado <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" 
                                value="{{ $medidor->cliente->primer_nombre . ' ' . $medidor->cliente->segundo_nombre . ' ' . $medidor->cliente->primer_apellido . ' ' . $medidor->cliente->segundo_apellido }}" 
                                readonly>
                            
                            <!-- Campo hidden para pasar el cliente_id -->
                            <input type="hidden" id="cliente_id" name="cliente_id" value="{{ $medidor->cliente_id }}">
                        </div>
                        
                        
                  </div>
                

                    </div>
                </div>
            
                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo">
                        <i class="fa-solid fa-save"></i> Guardar Medidor
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
    // Validación en el campo para permitir solo números
    document.getElementById('numero_medidor').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remueve cualquier caracter que no sea número
    });

    // Validación de Bootstrap para mostrar feedback
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

