@extends('adminlte::page')

@section('title', 'Acceso denegado | REGLA')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Acceso Denegado</strong></span>
        </h4>
    </div>
@endsection

@section('content')
    <div class="container">
        <div style="text-align: center; margin-top: 50px;">
            <!-- Ícono de Font Awesome (fas fa-ban), ajusta el estilo a tu preferencia -->
            <i class="fas fa-ban" style="font-size: 5em; color: #e74c3c;"></i>

            <h1 style="margin-top: 20px;">Acceso Denegado</h1>
            <p>No tienes permiso para ingresar a este módulo.</p>
        </div>
        {{-- Incluir el footer parcial --}}
        @include('partials.footer')
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('js')
    <script>
        console.log('Página de inicio cargada correctamente');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
