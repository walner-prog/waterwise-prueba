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

@section('title', 'editar egreso')



@section('content')
      @can('editar-egresos')
      <div class="container mt-4 toggle-container">
        @section('preloader')
          <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
        @stop
        
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol id="breadcrumb" class="breadcrumb mb-0 text-light">
                        <li class="breadcrumb-item">Hogar</li>
                        <li class="breadcrumb-item " aria-current="page">Registros de egresos</li>
                        <li class="breadcrumb-item active" aria-current="page"> Editar  egreso </li>
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
                    <i class="fas fa-dollar-sign fa-2x mr-2"></i>
                    @if(isset($egreso))
                        Editar Egreso
                    @else
                        Registrar Egreso
                    @endif
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($egreso) ? route('egresos.update', $egreso->id) : route('egresos.store') }}" method="POST">
                    @csrf
                    @if(isset($egreso))
                        @method('PUT') <!-- Método PUT para editar egreso -->
                    @endif
                    
                    <div class="row">
                        <!-- Concepto -->
                      
                        <!-- Paguese a -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="pagado_a" class="bold">Paguese a: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="pagado_a" name="pagado_a" value="{{ old('pagado_a', $egreso->pagado_a ?? '') }}" required>
                                </div>
                                @if ($errors->has('pagado_a'))
                                    <div class="text-danger">{{ $errors->first('pagado_a') }}</div>
                                @endif
                            </div>
                        </div>
    
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="monto" class="bold">Monto <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input type="number" class="form-control" id="monto" name="monto" value="{{ old('monto', $egreso->monto ?? '') }}" required>
                                </div>
                                @if ($errors->has('monto'))
                                    <div class="text-danger">{{ $errors->first('monto') }}</div>
                                @endif
                            </div>
                        </div>
    
                    </div>
        
                    <div class="row">
                        <!-- Monto -->
                      
        
                        <!-- Fecha -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="fecha" class="bold">Fecha <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ old('fecha', $egreso->fecha ?? '') }}" required>
                                </div>
                                @if ($errors->has('fecha'))
                                    <div class="text-danger">{{ $errors->first('fecha') }}</div>
                                @endif
                            </div>
                        </div>
                    
    
                     <!-- Empleado -->
                     <div class="col-lg-8">
                        <div class="form-group">
                            <label for="empleado_id" class="bold">Empleado <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <select class="form-control" id="empleado_id" name="empleado_id" required>
                                    <option value="">Seleccione un empleado</option>
                                    @foreach ($empleados as $empleado)
                                        <option value="{{ $empleado->id }}" {{ old('empleado_id', $egreso->empleado_id ?? '') == $empleado->id ? 'selected' : '' }}>
                                            {{ $empleado->nombre }} {{ $empleado->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('empleado_id'))
                                <div class="text-danger">{{ $errors->first('empleado_id') }}</div>
                            @endif
                        </div>
                    </div>
    
        
                    <div class="row">
                       
                        <!-- Observaciones -->
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="descripcion" class="bold">Observaciones</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-comments"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion', $egreso->descripcion ?? '') }}">
                                </div>
                                @if ($errors->has('descripcion'))
                                    <div class="text-danger">{{ $errors->first('descripcion') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
        
                    <div class="modal-footer">
                        
                        <button type="submit" class="btn btn-primary">
                            @if(isset($egreso)) Actualizar Egreso @else Guardar Egreso @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        
                    
            
        </div>
       
      @endcan

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


<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>


</script>



@stop
    
</body>
</html>

