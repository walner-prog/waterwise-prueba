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

@section('title', 'Crear empleado')



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
                    <li class="breadcrumb-item " aria-current="page">Registros de Lecturas </li>
                    <li class="breadcrumb-item active" aria-current="page"> Crear Registro </li>
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


    @can('crear-empleados')
    <div class="card">

            
        <div class="card-header bg-indigo">
           <h3>Agregar Empleado</h3>
        </div>
        <div class="card-body">
         <div class="row">
           <div class="col-lg-6">
            <form action="{{ route('empleados.store') }}" method="POST">
              @csrf
          
              <div class="form-group">
                  <label for="usuario_id">Usuario</label>
                  <select name="usuario_id" class="form-control" id="usuarioSelect" required onchange="fillFields(this)">
                      <option value="">Seleccione un usuario</option>
                      @foreach($usuarios as $usuario)
                      <option value="{{ $usuario->id }}"
                          data-name="{{ explode(' ', $usuario->name)[0] }}" 
                          data-lastname="{{ explode(' ', $usuario->name)[1] ?? '' }}" 
                          data-role="{{ implode(', ', $usuario->getRoleNames()->toArray()) }}">
                          <strong class="text-info">Nombre:</strong> {{ $usuario->name }} -
                          <strong class="text-info">Email:</strong> {{ $usuario->email }} -
                          <strong class="text-info">Rol:</strong> {{ implode(', ', $usuario->getRoleNames()->toArray()) }}
                      </option>
                      @endforeach
                  </select>
              </div>
          
              <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" class="form-control" name="nombre" id="nombre" required readonly>
              </div>
              <div class="form-group">
                  <label for="apellido">Apellido</label>
                  <input type="text" class="form-control" name="apellido" id="apellido" required readonly>
              </div>
              <div class="form-group">
                  <label for="puesto">Puesto</label>
                  <input type="text" class="form-control" id="puesto" name="puesto" required readonly>
              </div>
          
              <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
          
          
          
          
        </div>
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

              function fillFields(select) {
                  const selectedOption = select.options[select.selectedIndex];
                  document.getElementById('nombre').value = selectedOption.getAttribute('data-name');
                  document.getElementById('apellido').value = selectedOption.getAttribute('data-lastname');
                  document.getElementById('puesto').value = selectedOption.getAttribute('data-role');
              }
          
</script>

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

