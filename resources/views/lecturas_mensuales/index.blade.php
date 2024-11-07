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

@section('title', 'Lecturas')




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
                    <li class="breadcrumb-item active" aria-current="page">Registros de Lecturas Mensuales</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-2">
             @can('crear-lecturas_mensuales')
             <a href="{{ url('lecturas_mensuales/create') }}" class="btn btn-indigo mb-3">
                <i class="fas fa-plus"></i> Crear Lectura
            </a>
            @endcan
           
            
           
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
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

    
    @if (session('info'))
    <div class="alert alert-success col-lg-4">
        {{ session('info') }} 
        <a href="{{ route('lecturas_mensuales.voucher', session('lectura_id')) }}" target="_blank" class="btn btn-danger">Ver Recibo</a>
    </div>
   @endif

   @if (session('update'))
   <div class="alert alert-info col-lg-4">
       {{ session('update') }} 
       <a href="{{ route('lecturas_mensuales.voucher', session('lectura_id')) }}" target="_blank" class="btn btn-danger">Ver Recibo</a>
   </div>
   @endif
    
       @can('ver-lecturas_mensuales')
       <div class="table-responsive">
        <table id="lecturasTable" class="min-w-full w-full w-100 border border-gray-300 shadow-md rounded-lg p-2 table-striped">
            <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full">
                <tr>
                    <th class=" p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">#</th>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Número de Medidor</th>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Nombre Cliente</th>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Apellido Cliente</th>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Lectura Anterior</th>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Lectura Actual</th>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Fecha</th>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Consumo</th>
                         {{--                  <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Fecha inicio /fin </th> --}}
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Mes leido</th>
                    <th class="p-1 px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Acciones</th>

                    
                 
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 w-full">
                <!-- Aquí se llenará con datos de la tabla -->
               
               
            </tbody>
        </table>
       </div>
      @endcan

      <div class="col-lg-8 mb-3 mt-4">

        <!-- Modal -->
<div class="modal fade" id="detalleLecturaModal" tabindex="-1" aria-labelledby="detalleLecturaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detalleLecturaLabel">Información de la Lectura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se cargarán los detalles de la lectura -->
                <p class="text-dark"><strong>Medidor ID:</strong> <span id="medidor_id"></span></p>
                <p class="text-dark"><strong>Cliente:</strong> <span id="cliente_nombre"></span></p>
                <p class="text-dark"><strong>Lectura Anterior:</strong> <span id="lectura_anterior"></span></p>
                <p class="text-dark"><strong>Lectura Actual:</strong> <span id="lectura_actual"></span></p>
                <p class="text-dark"><strong>Consumo:</strong> <span id="consumo"></span></p>
                <p class="text-dark"><strong>Fecha de Lectura:</strong> <span id="fecha_lectura"></span></p>
                <p class="text-dark"><strong>Fecha de Inicio:</strong> <span id="fecha_inicio"></span></p>
                <p class="text-dark"><strong>Fecha de Fin:</strong> <span id="fecha_fin"></span></p>
                <p class="text-dark"><strong>Mes Leído:</strong> <span id="mes_leido"></span></p>
            </div>
            
        </div>
    </div>
</div>

      
      </div>
  

</div>
@stop


@section('css')
<style>

</style>
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


<script>
  $(document).ready(function() {
    $('#lecturasTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('api/lecturas_mensuales') }}",
        columns: [
        { data: 'id' },
        { 
            data: 'medidor.numero_medidor',
            render: function (data, type, row) {
                return `<span class="text-primary font-weight-bold p-2">${data}</span>`;
            },
            createdCell: function(td) {
                $(td).addClass('p-2'); // Agrega padding a la celda
            }
        },
      
        { 
            data: 'cliente_nombre', 
            createdCell: function(td) {
                $(td).addClass('p-2'); // Agrega padding a la celda
            } 
        },
        { 
            data: 'cliente_apellido', 
            createdCell: function(td) {
                $(td).addClass('p-2'); // Agrega padding a la celda
            } 
        },
        { 
            data: 'lectura_anterior', 
            createdCell: function(td) {
                $(td).addClass('p-2'); // Agrega padding a la celda
            } 
        },
        { 
            data: 'lectura_actual', 
            createdCell: function(td) {
                $(td).addClass('p-2'); // Agrega padding a la celda
            } 
        },
        { 
            data: 'fecha_lectura', 
            createdCell: function(td) {
                $(td).addClass('p-2'); // Agrega padding a la celda
            } 
        },
        { 
            data: 'consumo', 
            createdCell: function(td) {
                $(td).addClass('p-2'); // Agrega padding a la celda
            } 
        },
        { 
            data: 'mes_leido', 
            createdCell: function(td) {
                $(td).addClass('p-2'); // Agrega padding a la celda
            } 
        },
        { 
            data: 'btn', 
            orderable: false, 
            searchable: false, 
            createdCell: function(td) {
                $(td).addClass('p-2'); // Agrega padding a la celda
            } 

            
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
                            { text: 'Lecturas Mensuales \n', fontSize: 18, bold: true, margin: [0, 0, 0, 10] },
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
                        };
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
                            '<h3>Lecturas Mensuales</h3>' +
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
$('#lecturasTable').on('click', '.delete-btn', function() {
    var id = $(this).data('id');
    var url = "{{ url('lecturas_mensuales') }}/" + id;

    // Obtén el número de medidor y los nombres del cliente desde la fila
    var numeroMedidor = $(this).closest('tr').find('td:nth-child(2)').text(); // Cambia el índice según la columna
    var clienteNombre = $(this).closest('tr').find('td:nth-child(3)').text(); // Cambia el índice según la columna
    var clienteApellido = $(this).closest('tr').find('td:nth-child(4)').text(); // Cambia el índice según la columna

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
                html: `Por favor, copia el número del medidor: <strong>${numeroMedidor}</strong> y pégalo a continuación para confirmar la eliminación.<br>
                       Cliente: ${clienteNombre} ${clienteApellido}`,
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
                            $('#lecturasTable').DataTable().ajax.reload();
                            Swal.fire(
                                'Eliminado!',
                                'La lectura ha sido eliminada.',
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
    function verDetalleLectura(id) {
    $.ajax({
        url: `/lecturas_mensuales/${id}`, // Cambia la URL según tu ruta
        type: 'GET',
        success: function(data) {
            // Cargar los datos en el modal
            $('#medidor_id').text(data.medidor_id);
            $('#cliente_nombre').text(data.cliente_nombre);
            $('#lectura_anterior').text(data.lectura_anterior);
            $('#lectura_actual').text(data.lectura_actual);
            $('#consumo').text(data.consumo);
            $('#fecha_lectura').text(data.fecha_lectura);
            $('#fecha_inicio').text(data.fecha_inicio);
            $('#fecha_fin').text(data.fecha_fin);
            $('#mes_leido').text(data.mes_leido);
            
            // Mostrar el modal
            $('#detalleLecturaModal').modal('show');
        },
        error: function() {
            alert('Error al cargar los datos de la lectura.');
        }
    });
}

</script>

@stop
    
</body>
</html>

