@extends('adminlte::page')

@section('title', 'Editar Cooperadora para ' . $alumno->nombre . ' ' . $alumno->apellido)

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light">Pago de Cooperadora </span>
            <span class="badge bg-light border border-secondary"><strong>{{ $alumno->nombre }}
                    {{ $alumno->apellido }}</strong></span>
            <span class="badge bg-light">Año Lectivo </span>
            <span class="badge bg-light border border-secondary"><strong>{{ $historial->anio_lectivo }}</strong></span>
        </h4>
        <div class="d-flex">
            <a href="{{ route('alumnos.index') }}" title="Volver" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card p-4">
            <form action="{{ route('historial.actualizarCooperadora', $alumno->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="pago_cooperadora" class="form-label">Pago Cooperadora</label>
                    <input type="number" name="pago_cooperadora" class="form-control" min="0" max="50000" maxlength="6"
                        value="{{ old('pago_cooperadora', $historial->pago_cooperadora) }}" required>
                </div>

                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('historial.index', $alumno->id) }}" class="btn btn-secondary">Cancelar</a>
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
        console.log('Editar Cooperadora cargado');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
