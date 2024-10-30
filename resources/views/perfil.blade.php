
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
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
      
<body>
    
    
@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
    
@stop

@extends('adminlte::page')

@section('title', 'Editar Perfil')


@section('content')
<div class="container ">
  
  
  @if (session('info'))
  <div class="alert alert-info">
         <strong>{{ session('info') }}</strong>
  </div>
@endif
  <h2 class="text-center animate__animated animate__fadeIn"></h2>
  <!-- El elemento con la clase "animate__animated animate__fadeIn" tendrá una animación de desvanecimiento -->
  <div class="container py-5">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                <ol id="breadcrumb" class="breadcrumb mb-0  text-light">
                    <li class="breadcrumb-item active"aria-current="page">Hogar</li>
                    <li class="breadcrumb-item active" aria-current="page">Usuario </li>
                    <li class="breadcrumb-item " >Perfil de Usuario</li>
                </ol>
            </nav>
        </div>
        
    </div>
  
    
         @can('ver-perfil')
         <!-- Código o vista para ver el perfil del usuario -->
         <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('images/' . Auth::user()->profile_photo) }}" alt="Foto de Perfil"
                                class="rounded-circle img-fluid" style="width: 150px;">
                        @else
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                                class="rounded-circle img-fluid" style="width: 150px;">
                        @endif
                        <h5 class="my-3">{{ Auth::user()->name }}</h5>
                       
                        @if(Auth::user()->role)
                        <p class="text-muted mb-1"><strong>Rol:</strong> {{ Auth::user()->role }}</p>
                        @endif
                        <p class="text-muted mb-1"><strong>Correo Electrónico:</strong> {{ Auth::user()->email }}</p>
                        @if(Auth::user()->Contacto)
                            <p class="text-muted mb-1"><strong>Contacto:</strong> {{ Auth::user()->Contacto }}</p>
                        @endif
                        @if(Auth::user()->Direccion)
                            <p class="text-muted mb-1"><strong>Dirección:</strong> {{ Auth::user()->Direccion }}</p>
                        @endif
                        <div class="d-flex justify-content-center mb-2">
                            
                        </div>
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                   
                </div>
            </div>
            @endcan
               
              @can('editar-perfil')
                 <!-- Código o vista para editar el perfil del usuario -->
                 <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
        
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">Nombre:</label>
                                    <div class="col-sm-9">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Correo Electrónico:</label>
                                    <div class="col-sm-9">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label for="profile_photo" class="col-sm-3 col-form-label">Foto de Perfil:</label>
                                    <div class="col-sm-9">
                                        <input id="profile_photo" type="file" class="form-control" name="profile_photo">
                                        <br>
                                        @if(Auth::user()->profile_photo)
                                        <img src="{{ asset('images/' . Auth::user()->profile_photo) }}" alt="Foto de Perfil" width="100">
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-info">Actualizar Perfil</button>
                                        @if (Route::has('password.request'))
                                        <a class="btn btn-info btn-outline-indigo" href="{{ route('change_password') }}">
                                            {{ __('Cambiar contraseña?') }}
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                               
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                                
                            </div>
                        </div>
                    </div>
                </div>
              @endcan
           
        </div>
       
     
     
  </div>
  
</div>
<br>
@stop

@section('js')
<script>

  
</script>
  
@endsection
</body>
</html>
