<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-" crossorigin="anonymous" />
         <!-- Agrega esto en la sección head de tu HTML -->
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-TCJ6FYD6dMj4wsiWZz6swnVMqB5RW2MaebusGM1h8zE3DlX5C4sG5ndooMU2t7pLzYl5GmMKa9oB/njpy5Ul9w==" crossorigin="anonymous" />
              <!-- Otros encabezados -->
    
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
    
    @section('title', 'detalles del roll')
    
    
    
    @section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4 ">
                <ol id="breadcrumb" class="breadcrumb mb-0  text-light ">
                    <li class="breadcrumb-item active">Hogar</li>
                    <li class="breadcrumb-item active " aria-current="page">Registro de Roles de usuarios</li>
                    <li class="text-dark breadcrumb-item ">Detalles del Roll: <span class=" fw-bold">{{ $role->name }} .</span> </li>
                </ol>
            </nav>
        </div>
        
    </div>
    <div class="card shadow-lg">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="card-title">Detalles del Rol</h5> <br>
            <p class="text-dark">
                <strong>Permisos Asignados:</strong> {{ $assignedPermissionsCount }} de {{ $totalPermissions }} disponibles.
            </p>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Dividir permisos en 3 grupos -->
                @php
                    $permissions = $role->permissions->chunk(10);
                @endphp
    
                @foreach($permissions as $chunk)
                    <div class="col-lg-4 mb-3">
                        @if($chunk->isEmpty())
                            <p class="text-muted">No hay permisos asignados a este rol.</p>
                        @else
                            <h6 class="mt-4">Permisos:</h6>
                            <ul class="list-group">
                                @foreach($chunk as $permission)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $permission->name }}
                                        <span class="badge bg-primary rounded-pill">Permiso</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <div class="row mt-4">
                <div class="col-lg-4">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver a la lista de roles</a>
                </div>
                <div class="col-lg-8">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#rolesInfoModal">
                        ¿Qué son los roles y permisos?
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    

    <div class="modal fade" id="rolesInfoModal" tabindex="-1" aria-labelledby="rolesInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-gradient-primary text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="rolesInfoModalLabel">Información sobre Roles y Permisos</h5>
                    
                </div>
                <div class="modal-body">
                    <p><strong>Roles:</strong> Los roles definen un conjunto de permisos que se pueden asignar a los usuarios para controlar su acceso en el sistema.</p>
                    <p><strong>Permisos:</strong> Los permisos son acciones específicas que un usuario puede realizar, como crear, editar o eliminar registros.</p>
                    <p><strong>Importancia:</strong> Asignar roles y permisos correctamente es crucial para asegurar que los usuarios tengan acceso solo a las funcionalidades que necesitan.</p>
                    <p><strong>Precaución:</strong> Evita asignar permisos innecesarios que podrían comprometer la seguridad del sistema.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    @stop
    
    @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
    @stop
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
    @stop
    
    @section('js')
        <script> console.log('Hi!'); </script>
    @stop
</body>
</html>

