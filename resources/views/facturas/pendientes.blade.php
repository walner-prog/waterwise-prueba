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

@section('title', 'Facturas pendientes')




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
                    <li class="breadcrumb-item active" aria-current="page"> Facturas Pendientes</li>
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

   

 @can('ver-facturas-pendientes')
          
<div class="container">
   
    <button id="toggleFontSize" class="btn btn-secondary mb-3">Agrandar Texto</button>


    @if($facturasPendientes->isEmpty())
        <div class="alert alert-info">No hay facturas pendientes para este cliente.</div>
    @else

    <div class="card mb-3">
        <div class="card-header" id="ClienteDetails">
             <span class=" ">
              <strong>Cliente:</strong>   {{ $facturasPendientes->first()->cliente->primer_nombre ?? 'N/A' }} {{ $facturasPendientes->first()->cliente->segundo_nombre ?? 'N/A' }}
                {{ $facturasPendientes->first()->cliente->primer_apellido ?? 'N/A' }}      {{ $facturasPendientes->first()->cliente->segundo_apellido ?? 'N/A' }} 
             </span> 
             <span class=" ">
              <strong> No.Medidor:</strong>  {{ $facturasPendientes->first()->medidor->numero_medidor ?? 'N/A' }} 
             </span>

             <span class=" mt-3 ml-2">
                <span class="text-dark"><strong>Lectura pendiente:</strong> Desde {{ $lecturaAnterior ?? 'N/A' }} m³ hasta {{ $lecturaActual ?? 'N/A' }} m³</span>
                <span class="text-dark ml-2"><strong>Total a Pagar:</strong> C$ {{ number_format($totalMonto, 2) }}</span> {{-- Mostrar el total en córdobas --}}
             </span>
            
        </div>
    </div>

    <form id="pagoForm" method="POST" action="{{ route('facturas.confirmarPago') }}">
        @csrf
        <table id="ingresoDetails" class="min-w-full w-full w-100 border border-gray-300 shadow-md rounded-lg p-5">
            <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-full p-4">
                <tr>
                    <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Seleccionar</th>
                    <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">ID</th>
                    <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Fecha de Factura</th>
                    <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Mes Leído</th> <!-- Nueva columna -->
                    <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Consumo</th>
                    <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Monto Total</th>
                    <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Estado de Pago</th>
                    <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 w-full">
                @foreach($facturasPendientes as $factura)
                <tr class="{{ $factura->estado_pago == 'pendiente' ? 'bg-red-50 hover:bg-red-100' : 'bg-green-50 hover:bg-green-100' }}">
                    <td>
                        <input type="checkbox" name="factura_ids[]" value="{{ $factura->id }}">
                    </td>
                    <td>{{ $factura->id }}</td>
                    <td>{{ $factura->fecha_factura ? \Carbon\Carbon::parse($factura->fecha_factura)->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ $factura->lectura->mes_leido ?? 'N/A' }} {{ $factura->lectura->anio_leido ?? '' }}</td>
                    <td>{{ $factura->lectura->consumo ?? 'N/A' }} m³</td>
                    <td>C${{ number_format($factura->monto_total, 2) }}</td>
                    <td>
                        <span class="badge {{ $factura->estado_pago == 'pendiente' ? 'bg-danger' : 'bg-success' }}">
                            {{ ucfirst($factura->estado_pago) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver detalles de la factura">
                            Ver Detalles
                        </a>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
            
        </table>
       
    <!-- Mensaje de error -->
    <div id="mensajeValidacion" class="alert alert-danger mt-3" style="display: none;">
        <strong>Atención:</strong> Por favor, seleccione al menos una factura para proceder con el pago.
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-success">Pagar Facturas Seleccionadas</button>
    </div>
    </form>
    
        @endif
</div>
       @endcan



</div>
@stop
@section('css')


   <style>
    #mensajeValidacion {
    display: none;
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
    animation: fadeOut 5s forwards;
}

@keyframes fadeOut {
    0% { opacity: 1; }
    50% { opacity: 1; }
    100% { opacity: 0; display: none; }
}

   </style>
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
$(document).ready(function() {
    $('#facturasTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('api/facturas') }}",
        columns: [
            { data: 'id' },
            {  data: 'cliente',
                render: function (data, type, row) {
                 if (data) {
                   return `${data.primer_nombre} ${data.primer_apellido}`;
                  } else {
                    return 'Sin Cliente';
                 }
                }
            },
         
            { data: 'medidor.numero_medidor',
                render: function (data, type, row) {
                    return ` <span class="badge bg-indigo font-weight-bold">$${data}</span>`;
                }
            },
            
            { data: 'lectura_id',
                render: function (data, type, row) {
                    return ` <span class=" text-warning font-weight-bold">$${data}</span>`;
                }
            },
            { data: 'tarifa.precio_por_m3',
                render: function (data, type, row) {
                    return ` <span class="badge bg-success font-weight-bold">$${data}</span>`;
                }
            },
           
            { data: 'fecha_factura',
                render: function (data, type, row) {
                    return ` <span class=" text-info font-weight-bold">$${data}</span>`;
                }
            },
            { data: 'monto_total',
                render: function (data, type, row) {
                    return ` <span class=" text-indigo font-weight-bold">$${data}</span>`;
                }
            },
            { data: 'estado_pago',
                render: function (data, type, row) {
                    return data === 'pagado' ? 
                        '<span class="badge bg-success font-weight-bold">Pagado</span>' : 
                        '<span class="badge bg-danger font-weight-bold">Pendiente</span>';
                }
            },
            { data: 'btn', orderable: false, searchable: false }
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
                            { text: 'Lista de Facturas \n', fontSize: 18, bold: true, margin: [0, 0, 0, 10] },
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
                            '<h3>Lista de Facturas</h3>' +
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
    $('#facturasTable').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        var url = "{{ url('facturas') }}/" + id;
        
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
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire(
                            '¡Eliminado!',
                            'El registro ha sido eliminado.',
                            'success'
                        );
                        $('#facturasTable').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error',
                            'No se pudo eliminar el registro.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
</script>

<script>
    document.getElementById('pagoForm').addEventListener('submit', function(event) {
    const checkboxes = document.querySelectorAll('input[name="factura_ids[]"]:checked');
    const mensaje = document.getElementById('mensajeValidacion');
    
    if (checkboxes.length === 0) {
        event.preventDefault(); // Previene el envío del formulario
        mensaje.style.display = 'block'; // Muestra el mensaje
        mensaje.style.animation = 'fadeOut 10s forwards'; // Activa la animación

        // Oculta el mensaje después de 5 segundos
        setTimeout(function() {
            mensaje.style.display = 'none';
        }, 10000);
    }
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleFontSizeButton = document.getElementById('toggleFontSize');
        const ingresoDetails = document.getElementById('ingresoDetails');
        const ClienteDetails = document.getElementById('ClienteDetails');
        
        let isLargeFont = false;
  
        toggleFontSizeButton.addEventListener('click', function () {
            if (isLargeFont) {
                ingresoDetails.style.fontSize = '1em'; // Tamaño de fuente normal
                ClienteDetails.style.fontSize = '1em'; // Tamaño de fuente normal
                toggleFontSizeButton.textContent = 'Agrandar Texto';
            } else {
                ingresoDetails.style.fontSize = '1.4em'; // Tamaño de fuente grande
                ClienteDetails.style.fontSize = '1.4em'; // Tamaño de fuente grande
                toggleFontSizeButton.textContent = 'Reducir Texto';
            }
            isLargeFont = !isLargeFont;
        });
    });
  </script>
  

@stop
    
</body>
</html>

