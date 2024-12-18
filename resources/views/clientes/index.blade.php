<!DOCTYPE html>
<html lang="en">
 
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
  
      
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

@section('title', 'clientes')





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
                    <li class="breadcrumb-item active" aria-current="page">Registros de Clientes</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            @can('crear-clientes') <!-- Verificar si el usuario tiene permiso para crear clientes -->
                <button class="btn btn-indigo mb-3" data-toggle="modal" data-target="#createClienteForm">
                    <i class="fas fa-plus"></i> Crear Cliente
                </button>
            @endcan
        </div>
        <div class="col-lg-5 text-right">
            <a href="{{ route('clientes.import') }}" class="btn btn-success">
                Importar Clientes
            </a>
        </div>
        <div class="col-lg-3 text-right">
            <a href="{{ route('clientes.pdf') }}" target="blank" class="btn btn-primary">
                Descargar todos los clientes
            </a>
        </div>
        <div class=" col-lg-2 mb-3 text-right">
            <a href="{{ route('mostrar.formulario.notificaciones') }}" class="btn btn-primary">Enviar Notificaciones</a>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('update'))
        <div class="alert alert-warning">{{ session('update') }}</div>
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
   

    @can('ver-clientes')
    <div class="table-responsive">
        <table id="clientesTable" class="min-w-full border w-100 border-gray-300 shadow-md rounded-lg p-2 table-striped">
            <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                <tr>
                    <th class="p-2 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">#</th>
                    <th class="p-2 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200"> Nombre</th>
                    <th class="p-2 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Apellido</th>
                    <th class="p-2 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Dirección</th>
                    <th class="p-2 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Teléfono</th>
                    <th class="p-2 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Email</th>
                    <th class="p-2 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Registrado</th>
                    <th class="p-2 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <!-- Aquí se llenará con datos de la tabla -->
            </tbody>
        </table>
    </div>
    @endcan

    
  

    <div class="modal fade" id="createClienteForm" tabindex="-1" role="dialog" aria-labelledby="createClienteFormModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="createClienteFormModalLabel">Crear Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('clientes.store') }}" method="POST" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <div class="col-md-6">
                            <label for="primer_nombre" class="form-label">Primer Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" value="{{ old('primer_nombre') }}" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" required>
                            <div class="invalid-feedback">Solo se permiten letras y espacios, mínimo 3 caracteres.</div>
                        </div>
                    
                        <div class="col-md-6">
                            <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
                            <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre" value="{{ old('segundo_nombre') }}" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+">
                            <div class="invalid-feedback">Solo se permiten letras y espacios, mínimo 3 caracteres.</div>
                        </div>
                    
                        <div class="col-md-6">
                            <label for="primer_apellido" class="form-label">Primer Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" value="{{ old('primer_apellido') }}" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" required>
                            <div class="invalid-feedback">Solo se permiten letras y espacios, mínimo 3 caracteres.</div>
                        </div>
                    
                        <div class="col-md-6">
                            <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" value="{{ old('segundo_apellido') }}" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+">
                            <div class="invalid-feedback">Solo se permiten letras y espacios, mínimo 3 caracteres.</div>
                        </div>
                    
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}" required minlength="3">
                            <div class="invalid-feedback">La dirección debe tener al menos 3 caracteres.</div>
                        </div>
                    
                        <div class="col-md-4">
                            <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}" required>
                            <div class="invalid-feedback">El teléfono debe tener entre 8 y 12 dígitos.</div>
                        </div>
                    
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            <div class="invalid-feedback">Por favor ingrese un correo válido.</div>
                        </div>
                    
                        <div class="col-md-4">
                            <label for="fecha_registro" class="form-label">Fecha de Registro <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" value="{{ old('fecha_registro') }}" required>
                            <div class="invalid-feedback">Seleccione una fecha válida.</div>
                        </div>
                    
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                        </div>
                    </form>
                    
                   
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop



@section('js')
@livewireScripts
     <!-- Otros elementos del encabezado... -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     
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
    var baseUrl = "{{ url('/') }}"; // Obtén la URL base de la aplicación
</script>


<script>
$(document).ready(function() {
    $('#clientesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('api/clientes') }}",
        columns: [
    {
        data: 'id',
        render: function (data, type, row) {
            return `<span class="text-primary font-weight-bold p-2 d-block">${data}</span>`;
        },
        className: 'p-2', // Agregar padding a la columna
    },
    {
        data: 'primer_nombre',
        render: function (data, type, row) {
            return `<span class="text-primary font-weight-bold p-2 d-block">${data}</span>`;
        },
        className: 'p-2',
    },
    {
        data: 'primer_apellido',
        render: function (data, type, row) {
            return `<span class="text-primary font-weight-bold p-2 d-block">${data}</span>`;
        },
        className: 'p-2',
    },
    {
        data: 'direccion',
        className: 'p-2', // Agregar padding a la columna
    },
    {
        data: 'telefono',
        className: 'p-2',
    },
    {
        data: 'email',
        className: 'p-2',
    },
    {
        data: 'fecha_registro',
        className: 'p-2',
    },
    {
        data: 'id',
        render: function(data, type, row) {
            return `
                <div class="btn-wrapper" style="width: 270px">
                    <button type="button" class="btn btn-secondary btn-sm popover-btn" data-bs-toggle="popover" data-bs-html="true" data-bs-content="
                        <a href='${baseUrl}/api/facturas/${data}' class='btn btn-info btn-sm d-block mb-2'>
                            <i class='fas fa-file-invoice-dollar'></i> Ver Facturas Pendientes
                        </a>
                        <a href='${baseUrl}/api/his/clientes/${data}' class='btn btn-purple btn-sm d-block'>
                            <i class='fas fa-eye'></i> Ver Historial de Pagos
                        </a>
                    ">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <a href="${baseUrl}/clientes/${data}" class="btn btn-purple btn-sm">
                        <i class="fas fa-eye"></i> 
                    </a>
                    <a href="${baseUrl}/clientes/${data}/edit" class="btn btn-green btn-sm">
                        <i class="fas fa-edit"></i> 
                    </a>
                    <button type="button" class="btn btn-orange btn-sm delete-btn" data-id="${data}">
                        <i class="fas fa-trash"></i> 
                    </button>
                </div>
            `;
        },
        orderable: false,
        searchable: false,
        className: 'p-2', // Agregar padding a la columna de acciones
    },
],


        language: {
            search: "Buscar ",
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron resultados",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            info: "Mostrando página _PAGE_ de _PAGES_",
            paginate: {
                previous: "Anterior ",
                next: "Siguiente",
                first: "Primero",
                last: "Último",
            },
            sProcessing: "Procesando...",
        },
        lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        fixedHeader: true,
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i>',
                titleAttr: 'Copiar',
                className: 'bg-secondary',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: 'Exportar a Excel',
                className: 'bg-success',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                className: 'bg-danger',
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                customize: function (doc) {
                    doc.content.splice(0, 1, {
                        text: [
                            { text: 'Lista de Clientes \n', fontSize: 18, bold: true, margin: [0, 0, 0, 10] },
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
                    columns: ':not(:last-child)'
                },
                customize: function (win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(
                            '<h3>Lista de Clientes</h3>' +
                            '<p>Fecha: ' + new Date().toLocaleDateString() + ' ' + new Date().toLocaleTimeString() + '</p>' +
                            '<p>Usuario: ' + '{{ Auth::user()->name }}' + '</p>'
                        );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                extend: 'colvis',
                text: '<i class="fas fa-eye"> ',
                titleAttr: 'Ocultar columna',
                className: 'bg-dark'
            },
        ],
    });

   // Manejar la eliminación de registros con SweetAlert
$('#clientesTable').on('click', '.delete-btn', function() {
    var id = $(this).data('id');
    var url = "{{ url('clientes') }}/" + id;

    // Obtén el nombre y apellido del cliente desde la fila
    var clienteNombre = $(this).closest('tr').find('td:nth-child(2)').text(); // Cambia el índice si es necesario
    var clienteApellido = $(this).closest('tr').find('td:nth-child(3)').text(); // Cambia el índice si es necesario

    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Pide confirmar el nombre completo del cliente antes de eliminar
            Swal.fire({
                title: 'Confirmar eliminación',
                html: `Por favor, copia el nombre completo del cliente: <strong>${clienteNombre} ${clienteApellido}</strong> y pégalo a continuación para confirmar la eliminación.`,
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                preConfirm: (inputNombre) => {
                    // Comprobar que el nombre completo introducido coincida
                    if (inputNombre !== `${clienteNombre} ${clienteApellido}`) {
                        Swal.showValidationMessage(`El nombre introducido no coincide con ${clienteNombre} ${clienteApellido}`);
                    }
                }
            }).then((inputResult) => {
                if (inputResult.isConfirmed) {
                    // Si el nombre es correcto, proceder a eliminar
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#clientesTable').DataTable().ajax.reload();
                            Swal.fire(
                                'Eliminado!',
                                'El cliente ha sido eliminado.',
                                'success'
                            );
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'Ocurrió un error: ' + error,
                                'error'
                            );
                        }
                    });
                }
            });
        }
    });
});

});$(document).ready(function() {
    // Inicializar popovers manualmente
    $('[data-bs-toggle="popover"]').popover({
        trigger: 'manual',   // Desactivamos el comportamiento automático
        html: true,          // Permitimos HTML dentro del popover
        placement: 'bottom'  // Posición del popover
    });

    // Mostrar popover al hacer clic
    $('body').on('click', '.popover-btn', function (e) {
        var $this = $(this);
        // Cerramos otros popovers abiertos
        $('[data-bs-toggle="popover"]').not($this).popover('hide');
        // Abrimos el popover seleccionado
        $this.popover('toggle');
    });

    // Cerrar popover al hacer clic fuera del popover y botón
    $('body').on('click', function (e) {
        // Si el clic no es dentro del popover ni en el botón, cerramos el popover
        if (!$(e.target).closest('.popover-btn, .popover').length) {
            $('[data-bs-toggle="popover"]').popover('hide');
        }
    });
});


</script>

<script>
    $(document).ready(function() {
        // Obtener la fecha actual en formato YYYY-MM-DD
        var today = new Date().toISOString().split('T')[0];
        
        // Asignar la fecha actual al campo de fecha
        $('#fecha_registro').val(today);
    });
</script>

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
    
    <script>
        (function () {
            'use strict';
        
            // Agregar validación mínima de caracteres a los campos de texto
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
        
            // Validación de longitud para el campo de teléfono
            const phoneField = document.getElementById('telefono');
            if (phoneField) {
                phoneField.addEventListener('input', function() {
                    const length = phoneField.value.length;
                    if (length < 8 || length > 12) {
                        phoneField.setCustomValidity('El teléfono debe tener entre 8 y 12 dígitos.');
                    } else {
                        phoneField.setCustomValidity('');
                    }
                });
            }
        
            // Aplicar estilos de validación de Bootstrap a todos los formularios con clase needs-validation
            const forms = document.querySelectorAll('.needs-validation');
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

