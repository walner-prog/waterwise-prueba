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

@section('title', 'editar cliente')





@section('content')

 @can('editar-clientes')
<div class="container mt-4 toggle-container">
    @section('preloader')
      <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
     
   @stop
    
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                <ol id="breadcrumb" class="breadcrumb mb-0  text-light">
                    <li class="breadcrumb-item">Hogar</li>
                    <li class="breadcrumb-item active" aria-current="page">Editar  de Cliente</li>
                </ol>
            </nav>
        </div>
    </div>
     <div class="row">
        
     </div>

     @if (session('error'))
         <div class="alert alert-danger">{{ session('error') }}</div>
     @endif
     @if (session('update'))
         <div class="alert alert-warnig">{{ session('update') }}</div>
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



 
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-white" id="editClienteFormModalLabel">Editar Cliente</h5>
                
            </div>
            <div class="card-body">
                <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Usamos el método PUT para actualizar -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="primer_nombre">Primer Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" value="{{ old('primer_nombre', $cliente->primer_nombre) }}" required>
                                @if ($errors->has('primer_nombre'))
                                    <div class="text-danger">{{ $errors->first('primer_nombre') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="segundo_nombre">Segundo Nombre</label>
                                <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre" value="{{ old('segundo_nombre', $cliente->segundo_nombre) }}">
                                @if ($errors->has('segundo_nombre'))
                                    <div class="text-danger">{{ $errors->first('segundo_nombre') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="primer_apellido">Primer Apellido <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" value="{{ old('primer_apellido', $cliente->primer_apellido) }}" required>
                                @if ($errors->has('primer_apellido'))
                                    <div class="text-danger">{{ $errors->first('primer_apellido') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="segundo_apellido">Segundo Apellido</label>
                                <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" value="{{ old('segundo_apellido', $cliente->segundo_apellido) }}">
                                @if ($errors->has('segundo_apellido'))
                                    <div class="text-danger">{{ $errors->first('segundo_apellido') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="direccion">Dirección <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $cliente->direccion) }}" required>
                                @if ($errors->has('direccion'))
                                    <div class="text-danger">{{ $errors->first('direccion') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="telefono">Teléfono <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" required>
                                @if ($errors->has('telefono'))
                                    <div class="text-danger">{{ $errors->first('telefono') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $cliente->email) }}" required>
                                @if ($errors->has('email'))
                                    <div class="text-danger">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="fecha_registro">Fecha de Registro <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" value="{{ old('fecha_registro', $cliente->fecha_registro) }}" required>
                                @if ($errors->has('fecha_registro'))
                                    <div class="text-danger">{{ $errors->first('fecha_registro') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        
                        <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
   
       

    
</div>
@endcan

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
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    
        // Agregar validación mínima de caracteres para los campos de texto
        const textFields = document.querySelectorAll('input[type="text"]');
        textFields.forEach(field => {
            field.addEventListener('input', function () {
                if (field.value.length < 3) {
                    field.setCustomValidity('El campo debe tener al menos 3 caracteres.');
                } else {
                    field.setCustomValidity('');
                }
            });
        });
    
        // Validación para campos de texto solo letras
        const nameFields = ['primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido'];
        nameFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('input', function(event) {
                    event.target.value = event.target.value.replace(/[0-9]/g, '');
                });
            }
        });
    
        // Validación de teléfono con longitud entre 8 y 12
        const phoneField = document.getElementById('telefono');
        if (phoneField) {
            phoneField.addEventListener('input', function() {
                if (phoneField.value.length < 8 || phoneField.value.length > 12) {
                    phoneField.setCustomValidity('El teléfono debe tener entre 8 y 12 dígitos.');
                } else {
                    phoneField.setCustomValidity('');
                }
            });
        }
    })();
    </script>
    

@stop
    
</body>
</html>

