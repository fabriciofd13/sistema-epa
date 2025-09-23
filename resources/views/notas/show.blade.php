@extends('adminlte::page')

@section('title', 'Materias del Curso ' . $curso->nombre)

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2 text-muted">
            <span class="badge bg-light">Planillas de </span>
            <span class="badge bg-light border border-secondary"><strong>{{ $curso->nombre }}</strong></span>
            <span class="badge bg-light border border-secondary">{{ $curso->anio_lectivo }}</span>
        </h4>
        <div class="d-flex gap-2">
            <a href="{{ route('notas.graficos_trimestre', $curso->id) }}" class="btn btn-outline-info">
                <i class="fas fa-chart-line"></i> Ver Gráficos por Trimestre
            </a>
            <a href="{{ route('notas.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection


@section('content')
    <div class="container">
        <div class="card p-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materias as $materia)
                        <tr>
                            <td>{{ $materia->nombre }}</td>
                            <td>
                                <a href="{{ route('notas.ingresar', ['curso_id' => $curso->id, 'materia_id' => $materia->id]) }}"
                                    class="btn btn-success">Seleccionar</a>
                                <a href="{{ route('notas.resumen', ['curso_id' => $curso->id, 'materia_id' => $materia->id]) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    Ver Resumen
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Incluir el footer parcial --}}
        @include('partials.footer')
    </div>

@endsection
@section('js')
    <script>
        console.log('Página de cargada correctamente');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
