@extends('adminlte::page')

@section('title', 'Curso: ' . $curso->nombre)

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light">Curso</span>
            <span class="badge bg-light border border-secondary"><strong>{{ $curso->nombre }}</strong></span>
            <span class="badge bg-light border border-secondary"><strong>{{ $curso->anio_lectivo }}</strong></span>
        </h4>
        <div class="d-flex">
            <a href="{{ route('cursos.agregarAlumnos', $curso->id) }}" title="Agregar Alumnos [Ctrl + A]"
                class="btn btn-outline-primary me-2">
                <i class="fas fa-user-plus"></i> Agregar Alumnos
                <span class="badge bg-light text-primary border border-primary ms-2">Ctrl + A</span>
            </a>
            <a href="{{ route('cursos.index') }}" title="Volver [Ctrl + X]" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h4>Preceptor:
            @if ($curso->preceptor)
                {{ $curso->preceptor->nombre . ' ' . $curso->preceptor->apellido }}
            @else
                <span class="text-danger">Sin asignar</span>
            @endif
        </h4>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    @if (count($curso->historialAcademico))
                        <table class="table table-striped" id="alumnosporcurso">
                            <thead>
                                <tr>
                                    <th>Apellido</th>
                                    <th>Nombre</th>
                                    <th>DNI</th>
                                    <th>Tutor/Telefono</th>
                                    <th>Teléfono</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($curso->historialAcademico as $historial)
                                    <tr>
                                        <td>{{ $historial->alumno->apellido }}</td>
                                        <td>{{ $historial->alumno->nombre }}</td>
                                        <td>{{ $historial->alumno->dni }}</td>
                                        <td>
                                            {{ $historial->alumno->apellido_tutor ?? 'No registrado' }}
                                            {{ $historial->alumno->nombre_tutor }}<br>
                                            {{ $historial->alumno->celular_tutor ?? 'No registra celular' }}
                                        </td>
                                        <td>{{ $historial->alumno->telefono ?? 'No registrado' }}</td>
                                        <td>
                                            <a href="{{ route('historial.index', $historial->alumno->id) }}"
                                                class="btn btn-info btn-sm" title="Ver Historial Académico">
                                                <i class="fas fa-folder-open"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay alumnos inscriptos en este curso. <a
                                                href="{{ route('cursos.agregarAlumnos', $curso->id) }}">Inscribir</a></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @else
                        <div class="row">
                            <div class="col-md-12 text-center">
                                No hay alumnos inscriptos en este curso. <a
                                    href="{{ route('cursos.agregarAlumnos', $curso->id) }}">Inscribir</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
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
            // Verifica si se presionó Ctrl + N (o Command + N en Mac)
            if ((e.ctrlKey || e.metaKey) && (e.key === 'a' || e.key === 'A')) {
                // Evita la acción por defecto (nueva ventana)
                e.preventDefault();

                // Redirecciona a la ruta de "Nuevo Alumno"
                window.location.href = "{{ route('cursos.agregarAlumnos', $curso->id) }}";
            }
            if ((e.ctrlKey || e.metaKey) && (e.key === 'x' || e.key === 'X')) {
                // Evita la acción por defecto (abrir nueva ventana)
                e.preventDefault();

                // Redirecciona a la ruta de "Nueva Inscripción"
                window.location.href = "{{ route('cursos.index') }}";
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#alumnosporcurso').DataTable({
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    infoPostFix: "",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    },
                },
                // IMPORTANTE: poner la 'l' para que aparezca el menú de registros
                dom: 'lBfrtip',
            });
        });
    </script>
@endsection
