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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

@section('title', 'Medidores')



@section('content')
<div class="container  toggle-container">
    @section('preloader')
      <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    @stop
    
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                <ol id="breadcrumb" class="breadcrumb mb-0 text-light">
                    <li class="breadcrumb-item">Hogar</li>
                    <li class="breadcrumb-item active" aria-current="page">Registros de Medidores</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        @can('crear-medidores')
        <div class="col-lg-2">
            <a href="{{ url('medidores/create') }}" class="btn btn-indigo mb-3">
                <i class="fas fa-plus"></i> Crear Medidor
            </a>
            
        </div>
       @endcan
      
    
       
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


    @can('ver-medidores')
    <div class="table-responsive">
        <table id="medidoresTable" class="min-w-full w-full w-100 border border-gray-300 shadow-md rounded-lg p-2 table-striped">
            <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
                <tr>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">#</th>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Medidor</th>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Nombre  </th>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Apellido </th>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Ubicación</th>
                    <th class="p-1px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 w-full">
                <!-- Aquí se llenará con datos de la tabla -->
            </tbody>
        </table>
    </div>
    @endcan
   
    

   
      
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#medidoresTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('api/medidores') }}",
        columns: [
    { data: 'id', className: 'p-2' },
    { 
        data: 'numero_medidor',
        render: function (data, type, row) {
            return `<span class="text-primary font-weight-bold p-2">${data}</span>`;
        },
        className: 'p-2' // Aplicando padding a esta columna
    },
    { data: 'cliente_nombre', className: 'p-2' },
    { data: 'cliente_apellido', className: 'p-2' },
    { 
        data: 'ubicacion', 
        className: 'd-none d-md-table-cell p-2' // Agregando padding y ocultando en pantallas pequeñas
    },
    { data: 'btn', orderable: false, searchable: false, className: 'p-2' }
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
                            { text: 'Lista de Medidores \n', fontSize: 18, bold: true, margin: [0, 0, 0, 10] },
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
                            '<h3>Lista de Medidores</h3>' +
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
$('#medidoresTable').on('click', '.delete-btn', function() {
    var id = $(this).data('id');
    var url = "{{ url('medidores') }}/" + id;
    var numeroMedidor = $(this).closest('tr').find('td:nth-child(2)').text(); // Cambia el índice si el número de medidor no es la segunda columna

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
            // Pide el número de medidor a eliminar
            Swal.fire({
                title: 'Confirmar eliminación',
                text: `Por favor, introduce el número del medidor (${numeroMedidor}) para confirmar la eliminación.`,
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                preConfirm: (inputNumero) => {
                    // Comprobar que el número introducido coincida
                    if (inputNumero !== numeroMedidor) {
                        Swal.showValidationMessage(`El número de medidor no coincide con ${numeroMedidor}`);
                    }
                }
            }).then((inputResult) => {
                if (inputResult.isConfirmed) {
                    // Si el número es correcto, proceder a eliminar
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#medidoresTable').DataTable().ajax.reload();
                            Swal.fire(
                                'Eliminado!',
                                'El medidor ha sido eliminado.',
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

});


</script>

<script>
    $(document).ready(function() {
    $('#cliente_id').select2({
        placeholder: "Seleccionar cliente",
        allowClear: true,
        width: '100%', // Asegura que Select2 ocupe el ancho completo
        minimumResultsForSearch: 1 // Muestra el campo de búsqueda cuando hay al menos 1 opción
    });
});
var $disabledResults = $(".js-example-disabled-results");
$disabledResults.select2();
</script>


@stop
    
</body>
</html>

