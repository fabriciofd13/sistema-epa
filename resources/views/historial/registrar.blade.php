@extends('adminlte::page')

@section('title', 'Registrar Inscripción para ' . $alumno->nombre . ' ' . $alumno->apellido)

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light">Nueva Inscripción</span>
            <span class="badge bg-light border border-secondary"><strong>{{ $alumno->nombre }}
                    {{ $alumno->apellido }}</strong></span>
        </h4>
        <div class="d-flex">
            <a title="Volver" href="{{ route('historial.index', $alumno->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card p-4">
           <form action="{{ route('historial.guardar', ['alumno' => $alumno->id]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Año Lectivo</label>
                    <input type="number" min="2000" max="2050" minlength="4" maxlength="4" name="anio_lectivo"
                        class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Curso</label>
                    <select name="id_curso" class="form-control" required>
                        <option value="">Seleccione un curso</option>
                        @foreach ($cursos as $curso)
                            <option value="{{ $curso->id }}">{{ $curso->nombre }} ({{ $curso->anio_lectivo }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="cooperadora">Cooperadora</label>
                    <input type="number" min="0" max="50000" name="cooperadora" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Registrar</button>
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
        console.log('Página de inicio cargada correctamente');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection