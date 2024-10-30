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

@section('title', 'Crear')



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
                    <li class="breadcrumb-item " aria-current="page">Registros de Medidores</li>
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

    

    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header card-indigo">
            <h3 class="text-center font-weight-light my-2 h3-text text-white">
                <i class="fa-solid fa-file-invoice-dollar fa-2x mr-2"></i>
                Registrar Factura
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('facturas.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Campo de Búsqueda del Cliente -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="buscar_cliente" class="bold">
                                <i class="fa-solid fa-search"></i> Buscar Cliente
                            </label>
                            <input type="text" class="form-control" id="buscar_cliente" placeholder="Buscar por nombres o apellidos">
                        </div>
                        <div id="lista_clientes" class="list-group"></div>
                    </div>
    
                    <!-- Cliente ID (Oculto) -->
                    <div class="col-lg-6" hidden>
                        <div class="form-group">
                            <label for="cliente_id" class="bold">Cliente seleccionado</label>
                            <select class="form-control" id="cliente_id" name="cliente_id" required></select>
                            @if ($errors->has('cliente_id'))
                                <div class="text-danger">{{ $errors->first('cliente_id') }}</div>
                            @endif
                        </div>
                    </div>
    
                    <!-- Cliente Seleccionado -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="cliente_id" class="bold">
                                <i class="fa-solid fa-id-card"></i> ID Cliente Seleccionado <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="cliente_id_id" name="cliente_id" value="{{ old('cliente_id') }}" required readonly>
                            @if ($errors->has('cliente_id'))
                                <div class="text-danger">{{ $errors->first('cliente_id') }}</div>
                            @endif
                        </div>
                    </div>
    
                    <!-- Selección de Medidor -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="medidor_id" class="bold">
                                <i class="fa-solid fa-hashtag"></i> Medidor <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="medidor_id" name="medidor_id" required>
                                <!-- Opciones de medidores dinámicamente -->
                            </select>
                            @if ($errors->has('medidor_id'))
                                <div class="text-danger">{{ $errors->first('medidor_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <!-- Selección de Lectura -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="lectura_id" class="bold">
                                <i class="fa-solid fa-file-alt"></i> Lectura Mensual <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="lectura_id" name="lectura_id" required>
                                <!-- Opciones de lecturas mensuales -->
                            </select>
                            @if ($errors->has('lectura_id'))
                                <div class="text-danger">{{ $errors->first('lectura_id') }}</div>
                            @endif
                        </div>
                    </div>
    
                    <!-- Selección de Tarifa -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tarifa_id" class="bold">
                                <i class="fa-solid fa-dollar-sign"></i> Tarifa <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="tarifa_id" name="tarifa_id" required>
                                <!-- Opciones de tarifas dinámicamente -->
                            </select>
                            @if ($errors->has('tarifa_id'))
                                <div class="text-danger">{{ $errors->first('tarifa_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <!-- Fecha de Factura -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="fecha_factura" class="bold">
                                <i class="fa-solid fa-calendar"></i> Fecha de Factura <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="fecha_factura" name="fecha_factura" value="{{ old('fecha_factura') }}" required>
                            @if ($errors->has('fecha_factura'))
                                <div class="text-danger">{{ $errors->first('fecha_factura') }}</div>
                            @endif
                        </div>
                    </div>
    
                    <!-- Monto Total -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="monto_total" class="bold">
                                <i class="fa-solid fa-dollar-sign"></i> Monto Total <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="monto_total" name="monto_total" value="{{ old('monto_total') }}" required>
                            @if ($errors->has('monto_total'))
                                <div class="text-danger">{{ $errors->first('monto_total') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <!-- Estado del Pago -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="estado_pago" class="bold">
                                <i class="fa-solid fa-money-check"></i> Estado del Pago <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="estado_pago" name="estado_pago" required>
                                <option value="pendiente" {{ old('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="pagado" {{ old('estado_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                            </select>
                            @if ($errors->has('estado_pago'))
                                <div class="text-danger">{{ $errors->first('estado_pago') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo">
                        <i class="fa-solid fa-save"></i> Guardar Factura
                    </button>
                </div>
            </form>
        </div>
    </div>
    
              
                
        
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

<!-- CDN de Buttons para DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.flash.min.js"></script>
<scr'
ipt src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>



</script>

<script>
  
  $(document).ready(function() {
        $('#cliente_id').change(function() {
            var clienteId = $(this).val(); // Obtener el ID del cliente seleccionado
            if (clienteId) {
                $.ajax({
                    url: '/api/clientes/' + clienteId, // Ruta para obtener los detalles del cliente
                    type: 'GET',
                    success: function(response) {
                        // Rellenar los campos con la información del cliente
                        $('#cliente_id_id').val(response.id);
                        $('#primer_nombre').val(response.primer_nombre);
                        $('#segundo_nombre').val(response.segundo_nombre);
                        $('#primer_apellido').val(response.primer_apellido);
                        $('#segundo_apellido').val(response.segundo_apellido);
                       
                        // Rellena el contenedor de información del cliente
                        $('#info_primer_nombre').text(response.primer_nombre);
                        $('#info_segundo_nombre').text(response.segundo_nombre);
                        $('#info_primer_apellido').text(response.primer_apellido);
                        $('#info_segundo_apellido').text(response.segundo_apellido);

                        $('#info_direccion').text(response.direccion);
                        $('#info_segundo_telefono').text(response.telefono);
                        $('#info_segundo_email').text(response.email);
                        $('#info_segundo_registro').text(response.registro);  
                       
                    }
                });
            }
        });
    });

    $(document).ready(function() {
    function fetchClientes(page = 1) {
        var query = $('#buscar_cliente').val();
        if (query.length > 2) {
            $.ajax({
                url: "{{ route('buscarcliente') }}",
                type: "GET",
                data: {'query': query, 'page': page},
                success: function(data) {
                    $('#lista_clientes').empty();
                    if (data.data.length > 0) {
                        $.each(data.data, function(index, cliente) {
                            $('#lista_clientes').append('<a href="#" class="list-group-item list-group-item-action custom-list-item" data-id="' + cliente.id + '">' + cliente.primer_nombre + ' ' + cliente.segundo_nombre + ' ' + cliente.primer_apellido + ' ' + cliente.segundo_apellido + '</a>');
                        });

                        var pagination = '<nav class="pagination-container" aria-label="Page navigation"><ul class="pagination">';

                        if (data.prev_page_url) {
                            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="1">Primera</a></li>';
                            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + (data.current_page - 1) + '">Anterior</a></li>';
                        }

                        var startPage = Math.max(data.current_page - 2, 1);
                        var endPage = Math.min(data.current_page + 2, data.last_page);

                        if (startPage > 1) {
                            pagination += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }

                        for (var i = startPage; i <= endPage; i++) {
                            pagination += '<li class="page-item ' + (i === data.current_page ? 'active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                        }

                        if (endPage < data.last_page) {
                            pagination += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }

                        if (data.next_page_url) {
                            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + (data.current_page + 1) + '">Siguiente</a></li>';
                            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + data.last_page + '">Última</a></li>';
                        }

                        pagination += '</ul></nav>';

                        $('#lista_clientes').append(pagination);
                    } else {
                        $('#lista_clientes').append('<a href="#" class="list-group-item list-group-item-action disabled">No se encontraron resultados</a>');
                    }
                }
            });
        } else {
            $('#lista_clientes').empty();
        }
    }

    $('#buscar_cliente').on('keyup', function() {
        fetchClientes();
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        fetchClientes(page);
    });

    $(document).on('click', '.list-group-item-action', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var nombre = $(this).text();

        $('#cliente_id').empty().append('<option value="' + id + '" selected>' + nombre + '</option>');
        $('#cliente_id').change();
        $('#lista_clientes').empty();
        $('#buscar_cliente').val('');
    });

    $('#cliente_id').change(function() {
        var clienteId = $(this).val();
        if (clienteId) {
            $.ajax({
                url: '/api/clientes/' + clienteId,
                type: 'GET',
                success: function(response) {
                    // Puedes actualizar otros campos del formulario aquí si es necesario
                    $('#cliente_id').val(response.id); // Ajusta según los datos que necesites
                    $('#cliente_id_id').val(response.id);
                }
            });
        }
    });
});

</script>



@stop
    
</body>
</html>

