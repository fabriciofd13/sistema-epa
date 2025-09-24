@extends('adminlte::page')

@section('title', 'Legajo Preceptor | REGLA')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Preceptor</strong></span>
        </h4>
        <div class="d-flex">
            <a href="{{ route('home') }}" title="Volver" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container text-center">
        <div class="card p-4">
            <p><strong>ID:</strong> {{ $preceptor->id }}</p>
            <p><strong>Apellido y Nombre:</strong> {{ $preceptor->apellido }}, {{ $preceptor->nombre }}</p>
            <p><strong>DNI:</strong> {{ $preceptor->dni }}</p>
            <p><strong>CUIL:</strong> {{ $preceptor->cuil }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ $preceptor->fecha_nacimiento }}</p>
            <p><strong>Email:</strong> {{ $preceptor->email }}</p>
            <p><strong>Teléfono:</strong> {{ $preceptor->telefono }}</p>
            <p><strong>Celular:</strong> {{ $preceptor->celular }}</p>
            <p><strong>Título:</strong> {{ $preceptor->titulo }}</p>
            <p><strong>Segundo Título:</strong> {{ $preceptor->segundo_titulo }}</p>
            <p><strong>Localidad:</strong> {{ $preceptor->localidad }}</p>
            <p><strong>Dirección:</strong> {{ $preceptor->direccion }}</p>
            <p><strong>Barrio:</strong> {{ $preceptor->barrio }}</p>
            <p><strong>Número:</strong> {{ $preceptor->numero }}</p>
            <p><strong>Observaciones:</strong> {{ $preceptor->observaciones }}</p>
            <p><strong>Fecha Ingreso:</strong> {{ $preceptor->fecha_ingreso }}</p>
            <p><strong>Fecha Ingreso EPA:</strong> {{ $preceptor->fecha_ingreso_epa }}</p>
            <p><strong>Declaración Jurada:</strong> {{ $preceptor->declaracion_jurada ? 'Sí' : 'No' }}</p>
            <p><strong>Legajo:</strong> {{ $preceptor->legajo }}</p>
            <p><strong>Horas EPA:</strong> {{ $preceptor->horas_epa }}</p>
            <p><strong>Horas Totales:</strong> {{ $preceptor->horas_totales }}</p>
            <p><strong>Creado:</strong> {{ $preceptor->created_at }}</p>
            <p><strong>Actualizado:</strong> {{ $preceptor->updated_at }}</p>

            <a href="{{ route('preceptors.index') }}">Volver al listado</a>
            <a href="{{ route('preceptors.edit', $preceptor) }}">Editar</a>
            <form action="{{ route('preceptors.destroy', $preceptor) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este preceptor?')">
                    Eliminar
                </button>
            </form>
        </div>
        @include('partials.footer')

    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('js')
    <script>
        console.log('Página en construcción cargada');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
