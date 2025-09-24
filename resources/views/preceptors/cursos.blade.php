@extends('adminlte::page')

@section('title', 'Cursos del Preceptor | REGLA')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light">Cursos de </span>
            <span class="badge bg-light border border-secondary"><strong>{{ $preceptor->apellido }}, {{ $preceptor->nombre }}</strong></span>
        </h4>
        <div class="d-flex">
            {{-- <a href="{{ route('cursos.asignar_preceptor', $curso->id) }}" title="Asignar Preceptor [Ctrl + Q]"
                class="btn btn-outline-warning me-2">
                <i class="fas fa-user-plus"></i> Asignar Preceptor
                <span class="badge bg-light text-warning border border-warning ms-2">Ctrl + Q</span>
            </a>
            <a href="{{ route('cursos.agregarAlumnos', $curso->id) }}" title="Agregar Alumnos [Ctrl + A]"
                class="btn btn-outline-primary me-2">
                <i class="fas fa-user-plus"></i> Agregar Alumnos
                <span class="badge bg-light text-primary border border-primary ms-2">Ctrl + A</span>
            </a> --}}
            <a href="{{ route('preceptors.index') }}" title="Volver [Ctrl + X]" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">

        <div class="card p-4">
            @if ($preceptor->cursos->count())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th>Año Lectivo</th>
                                <th>Año</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($preceptor->cursos as $curso)
                                <tr>
                                    <td>{{ $curso->nombre }}</td>
                                    <td>{{ $curso->anio_lectivo }}</td>
                                    <td>{{ $curso->anio }}</td>
                                    <td>
                                        <a href="{{ route('cursos.asignar_preceptor', $curso->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Cambiar Preceptor
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info m-4">Este preceptor no tiene cursos asignados actualmente.</div>
            @endif
        </div>
    </div>

    @include('partials.footer')
@endsection

@section('js')
    <script>
        console.log('Página de Alumnos del Curso cargada correctamente.');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === 'x' || e.key === 'X')) {
                // Evita la acción por defecto (abrir nueva ventana)
                e.preventDefault();

                // Redirecciona a la ruta de "Nueva Inscripción"
                window.location.href = "{{ route('cursos.index') }}";
            }
        });
    </script>
@endsection
