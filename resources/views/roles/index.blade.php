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
    
    @section('title', 'Roles User')
    
  
    
    @section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4 ">
                <ol id="breadcrumb" class="breadcrumb mb-0  text-light  ">
                    <li class="breadcrumb-item active" aria-current="page">Hogar</li>
                    <li class="breadcrumb-item active" >Registro de Usuarios</li>
                    <li class="text-dark breadcrumb-item ">Bienvenido a la seccion de Roles de usuarios, {{ Auth::user()->name }} {{ Auth::user()->email }}.</li>
                </ol>
            </nav>
        </div>
        
    </div>
      
                <div class="card-header">
                     @can('crear-roles')
                   
                         <a class="btn btn-indigo btn-sm" href="{{ route('roles.create') }}">
                         <i class="fas fa-plus-circle mr-2"></i>Crear Nuevo rol</a>
                         @endcan
                  </div>
                  
                  @can('ver-roles')
                 
                  <div class="table table-responsive">
                    <table class="min-w-full w-100 border border-gray-300 shadow-md rounded-lg p-2 ">
                        <thead class="from-green-500 to-green-600 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Rol</th>
                                <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200" style="width: 300px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td class="px-4 py-3">{{ $role->id }}</td>
                                    <td class="px-4 py-3">{{ $role->name }}</td>
                                    <td class="px-4 py-3 text-right">
                                        @can('ver-roles')
                                            <a href="{{ route('roles.show', $role->id) }}" class="btn btn-purple btn-sm font-bold py-2 px-4 rounded-full inline-block">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('editar-roles')
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-green btn-sm font-bold py-2 px-4 rounded-full inline-block">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                    
                                        @can('borrar-roles')
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline-block; margin-left: 4px;">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-orange btn-sm font-bold py-2 px-4 rounded-full">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                     </table>
                  </div>
               
                
                   
                                <!-- Enlaces de paginación -->
                                <ul class="pagination">
                                    {{ $roles->links("pagination::bootstrap-4") }}
                                </ul>
                      @endcan
                 
            </div>

        
    @stop
    
    @section('css')
     
    @stop
    
    
    @section('js')
    @livewireScripts

        <script>
            

        </script>
    @stop
    </section>
    
</body>
</html>

