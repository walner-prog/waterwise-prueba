<!DOCTYPE html>
<html lang="es">
    <head>
      <!-- Include FontAwesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

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
    
  @section('title', 'Usuarios')
  
  @section('content')
  <div class="container">
  
      <div class="row">
          <div class="col">
              <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4 ">
                  <ol id="breadcrumb" class="breadcrumb mb-0 text-light ">
                      <li class="breadcrumb-item">Hogar</li>
                      <li class="breadcrumb-item active" aria-current="page">Registro de Usuarios</li>
                      <li class="text-dark breadcrumb-item active">Bienvenido a la seccion de Usuarios, {{ Auth::user()->name }} {{ Auth::user()->email }}.</li>
                  </ol>
              </nav>
          </div>
      </div>
  
        @can('crear-usuarios')
         
   
          <button class="btn btn-indigo mb-3" data-toggle="modal" data-target="#createUsuarioModal"><i class="fas fa-plus-circle mr-2"></i>Crear Nuevo Usuario</button>
          @endcan
      @if(session('error'))
      <div class="alert alert-danger">
          {{ session('error') }}
      </div>
      @endif
  
         @can('ver-usuarios')
             
       
          <div class="table-responsive">
              <table id="usuariosTable" class="min-w-full w-100 border border-gray-300 shadow-md rounded-lg p-2 table-striped">
                  <thead class="from-green-500 to-green-600 text-white">
                      <tr>
                          <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">#</th>
                          <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Nombre</th>
                          <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Email</th>
                          <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Rol</th>
                          <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Acciones</th>
                      </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200">
                      @foreach($usuarios as $usuario)
                      <tr>
                          <td class="px-6 py-3 whitespace-nowrap">{{ $usuario->id }}</td>
                          <td class="px-6 py-3 whitespace-nowrap">{{ $usuario->name }}</td>
                          <td class="px-6 py-3 whitespace-nowrap">{{ $usuario->email }}</td>
                          <td class="px-6 py-3 whitespace-nowrap">
                              @if (!empty($usuario->getRoleNames()))
                                  @foreach($usuario->getRoleNames() as $rolname)
                                      <span class="mr-4 badge bagge-datetime text-white">{{ $rolname }}</span>
                                  @endforeach
                              @else
                                  <span class="text-gray-500">Sin roles asignados</span>
                              @endif
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                             
                              <button class="btn btn btn-green btn-sm" data-toggle="modal" data-target="#editUsuarioModal{{ $usuario->id }}">    <i class="fas fa-edit"></i></button>
                            
  
                             
                              <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline-block;">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-orange btn-sm"><i class="fas fa-trash"></i></button>
                              </form>
                            
                          </td>
                      </tr>
  
                      <!-- Modal para Editar Usuario -->
                      <div class="modal fade" id="editUsuarioModal{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="editUsuarioModalLabel{{ $usuario->id }}" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="editUsuarioModalLabel{{ $usuario->id }}">Editar Usuario</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name">Nombre <i class="fas fa-user"></i></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $usuario->name }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="form-group">
                                            <label for="email">Email <i class="fas fa-envelope"></i></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $usuario->email }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="form-group">
                                            <label for="password">Password <i class="fas fa-lock"></i></label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Ingrese la password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="form-group">
                                            <label for="roles">Roles <i class="fas fa-user-tag"></i></label>
                                            <select name="roles[]" class="form-control @error('roles') is-invalid @enderror" multiple>
                                                @foreach($roles as $id => $nombre)
                                                    <option value="{{ $id }}" {{ in_array($id, $usuario->roles->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $nombre }}</option>
                                                @endforeach
                                            </select>
                                            @error('roles')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </form>
                                
                              </div>
                          </div>
                      </div>
                      @endforeach
                  </tbody>
              </table>
          </div>
   
          @endcan
      <!-- Modal para Crear Usuario -->
      <div class="modal fade" id="createUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="createUsuarioModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="createUsuarioModalLabel">Crear Usuario</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <form action="{{ route('usuarios.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Ingrese el Primer Nombre y Apellido <i class="fas fa-user"></i></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Por favor, ingrese solo letras">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="email">Ingrese el Correo <i class="fas fa-envelope"></i></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" required title="El correo es requerido">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="password">Ingrese la Contraseña <i class="fas fa-lock"></i></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Ingrese la contraseña">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="roles">Ingrese el Rol del Usuario <i class="fas fa-user-tag"></i></label>
                            <select name="roles[]" class="form-control @error('roles') is-invalid @enderror" multiple required>
                                @foreach($roles as $id => $nombre)
                                    <option value="{{ $id }}">{{ $nombre }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear Usuario</button>
                    </div>
                </form>
                
              </div>
          </div>
      </div>
  </div>
  @stop
  
  
  @section('css')
      <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
      <style>
        .invalid-feedback {
    display: none; /* Esto no debería estar presente */
}

.was-validated .invalid-feedback {
    display: block; /* Asegúrate de que esté visible al aplicar la clase was-validated */
}

      </style>
  @stop
  
  @section('js')
  
  @livewireScripts
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



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.dataTables.min.css">
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
<!-- JSZip -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<!-- PDFMake -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
<!-- Buttons HTML5 -->
<script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.html5.min.js"></script>
<!-- Buttons Print -->
<script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.print.min.js"></script>

  <script>

$(document).ready(function() {
    $('#usuariosTable').DataTable({
        "language": {
            "search": "Buscar ",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "paginate": {
                "previous": "Anterior ",
                "next": "Siguiente",
                "first": "Primero",
                "last": "Último"
            },
            "sProcessing": "Procesando..."
        },
        "lengthMenu": [[5, 15, 50, -1], [5, 15, 50, "Todos"]],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i>',
                titleAttr: 'Copiar',
                className: 'bg-secondary',
                exportOptions: {
                    columns: ':not(:last-child)' // Excluir última columna (Acciones)
                }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: 'Exportar a Excel',
                className: 'bg-success',
                exportOptions: {
                    columns: ':not(:last-child)' // Excluir última columna (Acciones)
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                className: 'bg-danger',
                exportOptions: {
                    columns: ':not(:last-child)' // Excluir última columna (Acciones)
                },
                customize: function (doc) {
                    doc.content.splice(0, 1, {
                        text: [
                            { text: 'Tabla de detalles Venta \n', fontSize: 18, bold: true, margin: [0, 0, 0, 10] },
                            { text: 'Fecha: ' + new Date().toLocaleDateString() + ' ' + new Date().toLocaleTimeString() + '\n', fontSize: 12, italics: true },
                            { text: 'Usuario: ' + '{{ Auth::user()->name }}' + '\n\n', fontSize: 12, italics: true }
                        ]
                    });
                    doc['footer'] = (function(page, pages) {
                        return {
                            columns: [
                                {
                                    alignment: 'left',
                                    text: ['Fecha: ', { text: new Date().toLocaleDateString() + ' ' + new Date().toLocaleTimeString() }]
                                },
                                {
                                    alignment: 'right',
                                    text: ['Página ', { text: page.toString() }, ' de ', { text: pages.toString() }]
                                }
                            ],
                            margin: 20
                        }
                    });
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i>',
                titleAttr: 'Imprimir',
                className: 'bg-info',
                exportOptions: {
                    columns: ':not(:last-child)' // Excluir última columna (Acciones)
                }
            }
        ]
    });
 // Manejar la eliminación de registros con SweetAlert
 $('#usuariosTable').on('click', '.delete-btn', function() {
        var form = $(this).closest('.delete-form'); // Obtener el formulario relacionado
        var email = $(this).data('email'); // Obtener el correo del usuario

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto! El correo del usuario es: " + email,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Si se confirma, enviar el formulario
            }
        });
    });
});



  </script>

<script>
(function () {
    'use strict'
  
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
  
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
  
          form.classList.add('was-validated')
        }, false)
      })
  })()
</script>

  
  @stop


    
</body>
</html>

    