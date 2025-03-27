@extends('adminlte::page')

@section('title', 'Listado de Alumnos')

@section('content_header')
    {{-- <h1>Listado de Alumnos</h1> --}}
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary">Lista de Alumnos</span>
        </h4>
        <div class="d-flex">
            <a href="{{ route('alumnos.create') }}" title="Agregar Alumno [Ctrl + A]" class="btn btn-outline-primary me-2">
                <i class="fas fa-user-plus"></i> Nuevo Alumno
                <span class="badge bg-light text-primary border border-primary ms-2">Ctrl + A</span>
            </a>
            <a href="{{ route('home') }}" title="Volver [Ctrl + X]" class="btn btn-outline-secondary">
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

        <div class="card pt-0">

            <div class="card-body">
                <div class="table-responsive">
                    <table id="alumnos-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th hidden>ID</th>
                                <th>Apellido</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Curso/División</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnos as $alumno)
                                @php
                                    // Año lectivo actual del sistema
                                    $anioActual = date('Y');

                                    // Buscar la inscripción del alumno en el año lectivo actual
                                    $inscripcionActual = $alumno
                                        ->historialAcademico()
                                        ->where('anio_lectivo', $anioActual)
                                        ->first();
                                @endphp
                                <tr>
                                    <td hidden>{{ $alumno->id }}</td>
                                    <td>{{ $alumno->apellido }}</td>
                                    <td>{{ $alumno->nombre }}</td>
                                    <td>{{ $alumno->dni }}</td>
                                    <td>
                                        @if ($inscripcionActual)
                                            {{ $inscripcionActual->curso->nombre }}
                                        @else
                                            <a href="{{ route('historial.registrar', $alumno->id) }}"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-user-plus"></i> Inscribir
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('alumnos.edit', $alumno->id) }}" title="Editar Datos del Alumno"
                                            class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('historial.index', $alumno->id) }}" class="btn btn-primary"
                                            title="Inscripciones">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                        <a href="{{ route('alumnos.notas.editar', $alumno->id) }}" class="btn btn-info"
                                            title="Ver Notas" hidden>
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('historial.editarCooperadora', $alumno->id) }}"
                                            title="Actualizar Pago de Cooperadora" class="btn btn-primary">
                                            <i class="fas fa-money-bill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Incluir el footer parcial --}}
    @include('partials.footer')
@endsection

@section('js')

    <script>
        console.log('Página de lista alumnos cargada correctamente');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script>
        document.addEventListener('keydown', function(e) {
            // Verifica si se presionó Ctrl + N (o Command + N en Mac)
            if ((e.ctrlKey || e.metaKey) && (e.key === 'a' || e.key === 'A')) {
                // Evita la acción por defecto (nueva ventana)
                e.preventDefault();

                // Redirecciona a la ruta de "Nuevo Alumno"
                window.location.href = "{{ route('alumnos.create') }}";
            }
            if ((e.ctrlKey || e.metaKey) && (e.key === 'x' || e.key === 'X')) {
                // Evita la acción por defecto (abrir nueva ventana)
                e.preventDefault();

                // Redirecciona a la ruta de "Nueva Inscripción"
                window.location.href = "{{ route('home') }}";
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#alumnos-table').DataTable({
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
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Descargar Excel',
                    className: 'btn btn-success'
                }],
                // Paginar de 20 en 20 por defecto
                lengthMenu: [
                    [20, 25, 50, 100, -1],
                    [20, 25, 50, 100, "Todos"]
                ],
                pageLength: 20
            });
        });
    </script>
@endsection
