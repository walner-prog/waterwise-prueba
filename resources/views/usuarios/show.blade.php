<!-- resources/views/usuarios/show.blade.php -->
{{-- @extends('layouts.app') --}}

<section>

    @extends('adminlte::page')
    
    @section('title', 'CAPS GNT')
    
    @section('content_header')
        <div class="card bg-primary text-white">
            <div class="card-header">
                <h1>Detalles del Usuario</h1>
            </div>
        </div>
    @stop
    
    
    @section('content')
        <div class="card">
            <div class="card-body ">
                
                      
                  
                  <p>ID: {{ $usuario->id }}</p>
                  <p>Nombre: {{ $usuario->name }}</p>
                  <p>Dirección: {{ $usuario->Direccion }}</p>
                  <p>Datos de Contacto: {{ $usuario->Contacto }}</p>
                  <a class="btn btn-secondary" href="{{ route('usuarios.index') }}">Volver a la lista de usuarios</a>
                   
            </div>
        </div>
    @stop
    
    @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
    @stop
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
    @stop
    
    @section('js')
        <script> console.log('Hi!'); </script>
    @stop
    </section>


