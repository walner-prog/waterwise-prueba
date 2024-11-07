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

@section('title', 'ventas')



@section('content')
<br>
<div class="container toggle-container">
    @section('preloader')
      <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    @stop
    
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                <ol id="breadcrumb" class="breadcrumb mb-0 text-light">
                    <li class="breadcrumb-item">Hogar</li>
                    <li class="breadcrumb-item active" aria-current="page">Registros de ventas</li>
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


    @can('ver-medidores')
    
    @livewire('venta-table')


    @endcan
   
    <br>

   
      
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS de DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/es.js"></script>


<script>
    $(document).ready(function() {
    $('.select2').select2({
        language: "es",
        placeholder: "Seleccione un Cliente",
        allowClear: true
    });
});
     

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.addEventListener('venta-notification', event => {
            let message = '';

            switch (event.detail.type) {
                case 'created':
                    message = 'La Venta ha sido creada correctamente.';
                    break;
                case 'updated':
                    message = 'La Venta ha sido actualizada correctamente.';
                    break;
                case 'deleted':
                    message = 'La Venta ha sido eliminada correctamente.';
                    break;
            }

            Swal.fire({
                icon: 'success',
                title: 'Operación Exitosa',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Otros listeners...

        window.addEventListener('show-detail-modal', event => {
            $('#detalleProductoModal').modal('show'); // Abre el modal
        });
    });
</script>




<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Selecciona una opción",
            allowClear: true
        });
    
        // Livewire event to update Select2 when the data changes
        Livewire.on('select2Updated', () => {
            $('.select2').select2({
                placeholder: "Selecciona una opción",
                allowClear: true
            });
        });
    
        // Re-initialize select2 when the modal is opened or the component is updated
        Livewire.hook('message.processed', (message, component) => {
            $('.select2').select2({
                placeholder: "Selecciona una opción",
                allowClear: true
            });
        });
    });
    </script>

@stop
    
</body>
</html>

