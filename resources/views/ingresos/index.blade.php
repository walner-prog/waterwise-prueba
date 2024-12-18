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

@section('title', 'ingresos')



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
                    <li class="breadcrumb-item active" aria-current="page">Registros de Ingresos</li>
                </ol>
            </nav>
        </div>
    </div>
     <div class="row">
         
     </div>

        @can('ver-ingresos')
        <div class="table-responsive">
            <!-- HTML -->
            <table id="ingresosTable" class="min-w-full w-100 border border-gray-300 shadow-md rounded-lg p-2">
                <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">#</th>
                        <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Nombre</th>
                        <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Apellido</th>
                        <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Monto</th>
                        <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Descripción</th>
                        <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Fecha</th>
                        
                        <th class="px-6 py-3 text-left text-base font-medium tracking-wider border-b border-gray-200">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Aquí se llenará con datos de la tabla -->
                </tbody>
            </table>
         </div>
        @endcan
   

        {{-- 
                <div class="modal fade" id="createIngresoForm" tabindex="-1" role="dialog" aria-labelledby="createIngresoFormModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="createIngresoFormModalLabel">Crear Ingreso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ingresos.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="monto">Monto <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="monto" name="monto" value="{{ old('monto') }}" required>
                                    @if ($errors->has('monto'))
                                        <div class="text-danger">{{ $errors->first('monto') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" required>
                                    @if ($errors->has('descripcion'))
                                        <div class="text-danger">{{ $errors->first('descripcion') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="fecha">Fecha <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
                                    @if ($errors->has('fecha'))
                                        <div class="text-danger">{{ $errors->first('fecha') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Ingreso</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
       --}}

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


<script>
   $(document).ready(function() {
    $('#ingresosTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('api/ingresos') }}",
        columns: [
        { data: 'id' },
        {
    data: 'cliente_primer_nombre',
    render: function(data, type, row) {
        return `<span>${data}</span>`;
    }
},
{
    data: 'cliente_primer_apellido',
    render: function(data, type, row) {
        return `<span>${data}</span>`;
    }
},

        { data: 'monto', 
            render: function(data, type, row) {
                return `<span class="text-primary font-weight-bold">${data}</span>`;
            }
        },
        { data: 'descripcion' },
        { data: 'fecha' },
       
        
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
                previous: "Anterior",
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
            { extend: 'copy', text: '<i class="fas fa-copy"></i>', titleAttr: 'Copiar', className: 'bg-secondary', exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i>', titleAttr: 'Exportar a Excel', className: 'bg-success', exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i>', titleAttr: 'Exportar a PDF', className: 'bg-danger', exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'print', text: '<i class="fas fa-print"></i>', titleAttr: 'Imprimir', className: 'bg-info', exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'colvis', text: '<i class="fas fa-eye"></i>', titleAttr: 'Ocultar columna', className: 'bg-dark' },
        ],
    });

    // Manejar la eliminación de registros con SweetAlert
    $('#ingresosTable').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        var url = "{{ url('ingresos') }}/" + id;
        
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
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#ingresosTable').DataTable().ajax.reload();
                        Swal.fire('Eliminado!', 'El ingreso ha sido eliminado.', 'success');
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'Ocurrió un error: ' + error, 'error');
                    }
                });
            }
        });
    });
});


</script>

@stop
    
</body>
</html>

