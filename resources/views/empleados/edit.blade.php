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

@section('title', 'editar tarifa')



@section('content')
   
       @can('editar-empleados')
                
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
                    <li class="breadcrumb-item active" aria-current="page"> Editar  tarifa </li>
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

    
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header card-indigo">
            <h3 class="text-center font-weight-light my-2 h3-text text-white">
                <i class="fa-solid fa-user fa-2x mr-2"></i>
                @if(isset($empleado))
                    Editar Empleado
                @else
                    Registrar Empleado
                @endif
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ isset($empleado) ? route('empleados.update', $empleado->id) : route('empleados.store') }}" method="POST">
                @csrf
                @if(isset($empleado))
                    @method('PUT') <!-- Utiliza el método PUT si estás editando un empleado existente -->
                @endif
                
                <div class="row">
                    <!-- Nombre -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="nombre" class="bold">
                                <i class="fa-solid fa-user"></i> Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $empleado->nombre ?? '') }}" required>
                            @if ($errors->has('nombre'))
                                <div class="text-danger">{{ $errors->first('nombre') }}</div>
                            @endif
                        </div>
                    </div>
    
                    <!-- Apellido -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="apellido" class="bold">
                                <i class="fa-solid fa-user"></i> Apellido <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido', $empleado->apellido ?? '') }}" required>
                            @if ($errors->has('apellido'))
                                <div class="text-danger">{{ $errors->first('apellido') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <!-- Puesto -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="puesto" class="bold">
                                <i class="fa-solid fa-briefcase"></i> Puesto <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="puesto" name="puesto" value="{{ old('puesto', $empleado->puesto ?? '') }}" required>
                            @if ($errors->has('puesto'))
                                <div class="text-danger">{{ $errors->first('puesto') }}</div>
                            @endif
                        </div>
                    </div>
    
                    <!-- Usuario -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="usuario_id" class="bold">
                                <i class="fa-solid fa-user-circle"></i> Usuario <span class="text-danger">*</span>
                            </label>
                            
                            <!-- Campo oculto para almacenar el ID del usuario -->
                            <input type="hidden" name="usuario_id" id="usuario_id" value="{{ $empleado->usuario_id }}">
                    
                            <!-- Campo de texto para mostrar el nombre del usuario -->
                            <input type="text" class="form-control" value="{{ $empleado->usuario->name }}" readonly>
                    
                            @if ($errors->has('usuario_id'))
                                <div class="text-danger">{{ $errors->first('usuario_id') }}</div>
                            @endif
                        </div>
                    </div>
                    
                </div>
    
                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo">
                        <i class="fa-solid fa-save"></i> @if(isset($empleado)) Actualizar Empleado @else Guardar Empleado @endif
                    </button>
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


<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.getElementById('usuarioSelect').addEventListener('change', function() {
        const usuarioId = this.value;
        if (usuarioId) {
            fetch(`/empleados/check/${usuarioId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Usuario ya registrado',
                            text: 'Este usuario ya está registrado como empleado.',
                            confirmButtonText: 'Aceptar'
                        });
                        // Limpia el campo de selección
                        document.getElementById('usuarioSelect').value = '';
                        // Limpia los campos de nombre, apellido y puesto
                        document.getElementById('nombre').value = '';
                        document.getElementById('apellido').value = '';
                        document.getElementById('puesto').value = '';
                    }
                });
        }
    });
  </script>


@stop
    
</body>
</html>

