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
    <!-- Agregar CSS de Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


   
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

@section('title', 'Crear lectura')



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

          <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="ultima_lectura">Información de la última lectura</label>
                    <div id="ultima_lectura" class="text-muted">Selecciona un medidor para ver el mes de  última lectura.</div>
                </div>
                
            </div>
            <div class="col-lg-6">
                 <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#ayudaLecturaModal">
                    Ayuda para Crear Lectura
                 </button>
            </div>
          </div>
        
  
    

    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header card-indigo ">
            <h3 class="text-center font-weight-light my-2 h3-text text-white">
                <i class="fa-solid fa-water fa-2x mr-2"></i>
                Registrar Lectura 
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('lecturas_mensuales.store') }}" method="POST">
                @csrf
                <div class="row">
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="medidor_id">Medidor <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="medidor_id" name="medidor_id" required>
                                <option value="">Seleccione un medidor</option>
                                @foreach($medidores as $medidor)
                                    @if($medidor->cliente)
                                        <option value="{{ $medidor->id }}" data-cliente-id="{{ $medidor->cliente->id }}" {{ old('medidor_id') == $medidor->id ? 'selected' : '' }}>
                                         <span class=" text-dark font-weight-bold">Cliente: </span>  {{ $medidor->cliente->primer_nombre }}   {{ $medidor->cliente->segundo_nombre }}
                                                   {{ $medidor->cliente->primer_apellido }}  {{ $medidor->cliente->segundo_apellido }} 
                                         <span class=" text-dark font-weight-bold">- # Medidor: </span>  {{ $medidor->numero_medidor }}
                                        </option>
                                    @else
                                        <option value="{{ $medidor->id }}" data-cliente-id="" {{ old('medidor_id') == $medidor->id ? 'selected' : '' }}>
                                            ID: {{ $medidor->id }} - Sin Cliente Asociado
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('medidor_id'))
                                <div class="text-danger">{{ $errors->first('medidor_id') }}</div>
                            @endif
                        </div>
                        <input type="hidden" class="form-control" id="cliente_id" name="cliente_id" value="{{ old('cliente_id') }}" required readonly>
                            @if ($errors->has('cliente_id'))
                                <div class="text-danger">{{ $errors->first('cliente_id') }}</div>
                            @endif
                    </div>
                    
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="lectura_anterior">
                                Lectura Anterior <span class="text-danger">*</span>
                                <span class="text-muted ">Este campo se llena automáticamente</span>
                            </label>
                            <input type="number" class="form-control" id="lectura_anterior" name="lectura_anterior" value="{{ old('lectura_anterior') }}" required placeholder="Este campo se llena automáticamente" readonly>
                            @if ($errors->has('lectura_anterior'))
                                <div class="text-danger">{{ $errors->first('lectura_anterior') }}</div>
                            @endif
                        </div>
                    </div>

                  
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="lectura_actual">Lectura Actual <span class="text-danger">*</span>
                             
                            </label>
                            <input type="number" class="form-control" id="lectura_actual" name="lectura_actual" value="{{ old('lectura_actual') }}" required>
                            @if ($errors->has('lectura_actual'))
                                <div class="text-danger">{{ $errors->first('lectura_actual') }}</div>
                            @endif
                        </div> 
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="fecha_lectura">Fecha de Lectura <span class="text-danger">*</span>
                               
                            </label>
                            <input type="date" class="form-control" id="fecha_lectura" name="fecha_lectura" value="{{ old('fecha_lectura') }}" required>
                            @if ($errors->has('fecha_lectura'))
                                <div class="text-danger">{{ $errors->first('fecha_lectura') }}</div>
                            @endif
                        </div>
                    </div>
    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de Inicio <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required readonly>
                            @if ($errors->has('fecha_inicio'))
                                <div class="text-danger">{{ $errors->first('fecha_inicio') }}</div>
                            @endif
                        </div>
                    </div>
    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de Fin <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}" required readonly>
                            @if ($errors->has('fecha_fin'))
                                <div class="text-danger">{{ $errors->first('fecha_fin') }}</div>
                            @endif
                        </div>
                    </div>
    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="mes_leido">Mes leído <span class="text-danger">*</span></label>
                            <select class="form-control" id="mes_leido" name="mes_leido" required readonly>
                                <option value="">Seleccione el mes</option>
                                <option value="enero" {{ old('mes_leido') == 'enero' ? 'selected' : '' }}>enero</option>
                                <option value="febrero" {{ old('mes_leido') == 'febrero' ? 'selected' : '' }}>febrero</option>
                                <option value="marzo" {{ old('mes_leido') == 'marzo' ? 'selected' : '' }}>marzo</option>
                                <option value="abril" {{ old('mes_leido') == 'abril' ? 'selected' : '' }}>abril</option>
                                <option value="mayo" {{ old('mes_leido') == 'mayo' ? 'selected' : '' }}>mayo</option>
                                <option value="junio" {{ old('mes_leido') == 'junio' ? 'selected' : '' }}>junio</option>
                                <option value="julio" {{ old('mes_leido') == 'julio' ? 'selected' : '' }}>julio</option>
                                <option value="agosto" {{ old('mes_leido') == 'agosto' ? 'selected' : '' }}>agosto</option>
                                <option value="septiembre" {{ old('mes_leido') == 'septiembre' ? 'selected' : '' }}>septiembre</option>
                                <option value="octubre" {{ old('mes_leido') == 'octubre' ? 'selected' : '' }}>octubre</option>
                                <option value="noviembre" {{ old('mes_leido') == 'noviembre' ? 'selected' : '' }}>noviembre</option>
                                <option value="diciembre" {{ old('mes_leido') == 'diciembre' ? 'selected' : '' }}>diciembre</option>
                            </select>
                            @if ($errors->has('mes_leido'))
                                <div class="text-danger">{{ $errors->first('mes_leido') }}</div>
                            @endif
                        </div>
                    </div>

                   
                    
                    
                </div>
    
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar Lectura</button>
                </div>
            </form>
        </div>
    </div>
    
              
      
  <!-- Modal -->
  <div class="modal fade" id="ayudaLecturaModal" tabindex="-1" aria-labelledby="ayudaLecturaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ayudaLecturaModalLabel">Ayuda para Crear Lectura</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Aquí puedes incluir el contenido de ayuda -->
          <p>Para crear una nueva lectura, sigue estos pasos:</p>
          <ul>
            <li>Selecciona el medidor y cliente correspondientes.</li>
            <li>La lectura anterior se llenará automáticamente.</li>
            <li>Introduce la lectura actual.</li>
            <li>Las fechas de inicio, fin y el mes leido se llenarán automáticamente con la fecha de lectura.</li>
            <li>Al guardar la lectura, se generará una factura automáticamente.</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  
  
  
        <br>
        <br>
        <br>
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

<!-- Asegúrate de incluir el JavaScript de Bootstrap para que funcione el modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/es.js"></script>


<script>
$(document).ready(function() {
    $('#medidor_id').change(function() {
        var medidorId = $(this).val();
        if (medidorId) {
            $.ajax({
                url: '{{ route("lectura.anterior", ":medidor_id") }}'.replace(':medidor_id', medidorId),
                type: 'GET',
                success: function(data) {
                    $('#lectura_anterior').val(data.lectura_anterior);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#lectura_anterior').val(0);
        }
    });
});
</script>

<script>
    $(document).ready(function() {
        $('#medidor_id').change(function() {
            var medidorId = $(this).val();
            if (medidorId) {
                $.ajax({
                    url: '{{ route("lectura.anterior", ":medidor_id") }}'.replace(':medidor_id', medidorId),
                    type: 'GET',
                    success: function(data) {
                        $('#lectura_anterior').val(data.lectura_anterior);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
    
               
            } else {
                $('#lectura_anterior').val(0); // Default to 0 if no medidor is selected
               // $('#mes_leido').val(""); // Clear mes_leido if no medidor is selected
            }
        });
    });
    </script>
<script>
    $(document).ready(function() {
        // Capturar el cambio en el select de medidores
        $('#medidor_id').on('change', function() {
            // Obtener el cliente_id del option seleccionado
            var clienteId = $(this).find(':selected').data('cliente-id');
            
            // Asignar el cliente_id al input de cliente_id
            $('#cliente_id').val(clienteId ? clienteId : '');
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Función que convierte el número de mes en nombre de mes en español
        function obtenerMesEnLetras(fecha) {
            const meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
            const mesNumero = new Date(fecha).getMonth(); // Obtener el número del mes (0-11)
            return meses[mesNumero]; // Retornar el mes en letras
        }
    
        // Detectar cuando se cambia la fecha
        $('#fecha_lectura').on('change', function() {
            const fechaSeleccionada = $(this).val(); // Obtener la fecha seleccionada
            if (fechaSeleccionada) {
                const mesEnLetras = obtenerMesEnLetras(fechaSeleccionada);
                $('#mes_leido').val(mesEnLetras); // Llenar el campo mes_leido con el mes en letras
            } else {
                $('#mes_leido').val(''); // Limpiar el campo si no hay fecha
            }
        });
    });
 </script>

<script>
    $(document).ready(function() {
        // Al cambiar el medidor
        $('#medidor_id').change(function() {
            var medidorId = $(this).val();
    
            if (medidorId) {
                // Llenar la lectura anterior
                $.ajax({
                    url: '{{ route("lectura.anterior", ":medidor_id") }}'.replace(':medidor_id', medidorId),
                    type: 'GET',
                    success: function(data) {
                        $('#lectura_anterior').val(data.lectura_anterior);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
    
                // Obtener el cliente_id del option seleccionado
                var clienteId = $(this).find(':selected').data('cliente-id');
                $('#cliente_id').val(clienteId ? clienteId : ''); // Asignar cliente_id
    
            } else {
                $('#lectura_anterior').val(0); // Default a 0 si no se selecciona medidor
                $('#cliente_id').val(''); // Limpiar cliente_id si no se selecciona medidor
            }
        });
    
        // Al cambiar la fecha de lectura
        $('#fecha_lectura').change(function() {
            var fechaLectura = $(this).val();
            if (fechaLectura) {
                // Obtener la fecha 30 días antes
                var fechaInicio = new Date(fechaLectura);
                fechaInicio.setDate(fechaInicio.getDate() - 30);
                var fechaFin = new Date(fechaLectura);
    
                // Formatear las fechas a 'YYYY-MM-DD'
                var options = { year: 'numeric', month: '2-digit', day: '2-digit' };
                var fechaInicioFormatted = fechaInicio.toLocaleDateString('en-CA', options);
                var fechaFinFormatted = fechaFin.toLocaleDateString('en-CA', options);
    
                // Asignar las fechas al input correspondiente
                $('#fecha_inicio').val(fechaInicioFormatted);
                $('#fecha_fin').val(fechaFinFormatted);
            } else {
                $('#fecha_inicio').val(''); // Limpiar si no hay fecha de lectura
                $('#fecha_fin').val('');
            }
        });
    });
    </script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            language: "es",
            placeholder: "Seleccione un Cliente",
            allowClear: true
        });

        // Manejar la selección de un medidor
        $('#medidor_id').on('change', function() {
            let medidorId = $(this).val();
            if (medidorId) {
                // Hacer una solicitud AJAX para obtener la última lectura
                $.ajax({
                    url: "{{ route('lecturas_mensuales.ultima_lectura_mes') }}",
                    method: 'GET',
                    data: { medidor_id: medidorId },
                    success: function(response) {
                        // Muestra el mes de la última lectura
                        $('#ultima_lectura').html(
                            '<div class="alert alert-warning">' +
                              '<h6><strong>Mes y Año de la Última Lectura:</strong></h6>' +
                               '<p class="mb-0"><span class="badge bg-primary">' + response.mes + '</span> ' +
                                '<span class="badge bg-secondary">' + response.anio + '</span></p>' +
                           '</div>'
                        );

                    },
                    error: function() {
                        $('#ultima_lectura').html('<strong>Error:</strong> No se pudo obtener la última lectura');
                    }
                });
            } else {
                $('#ultima_lectura').html('');
            }
        });
    });
</script>



    
@stop
    
</body>
</html>

