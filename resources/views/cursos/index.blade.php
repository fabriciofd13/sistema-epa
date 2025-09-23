@extends('adminlte::page')

@section('title', 'Listado de Cursos')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary">Lista de Cursos por Año</span>
        </h4>
        <div class="d-flex">
            @php
                $user = Auth::user();
            @endphp
            @if ($user->id_preceptor)
                <a href="{{ route('preceptor.cursos') }}" class="btn btn-outline-primary float-left">
                  <i class="fas fa-chalkboard-teacher"></i><strong> MIS CURSOS</strong>
                </a>
            @endif
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
        <div class="card">
            <div class="accordion" id="cursosAccordion">
                @foreach ($cursosAgrupados as $anio_lectivo => $cursos)
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="heading{{ $anio_lectivo }}">
                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $anio_lectivo }}"
                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $anio_lectivo }}">
                                📅 Año Lectivo: {{ $anio_lectivo }}
                            </button>
                        </h4>
                        <div id="collapse{{ $anio_lectivo }}"
                            class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                            aria-labelledby="heading{{ $anio_lectivo }}" data-bs-parent="#cursosAccordion">
                            <div class="accordion-body">
                                <div class="row">
                                    @foreach ($cursos as $curso)
                                        <div class="col-md-4">
                                            <div class="card shadow-lg">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $curso->nombre }}</h5>
                                                    <p class="card-text">
                                                        <strong>Preceptor:</strong>
                                                        {{ $curso->preceptor ? $curso->preceptor->nombre . ' ' . $curso->preceptor->apellido : 'Sin asignar' }}
                                                        <br>
                                                        <strong>Cantidad de Alumnos:</strong>
                                                        {{ $curso->historialAcademico->count() }}
                                                    </p>
                                                    <a href="{{ route('cursos.show', $curso->id) }}"
                                                        class="btn btn-success" title="Ver Curso">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('cursos.asignar_preceptor', $curso->id) }}"
                                                        class="btn btn-warning" title="Cambiar Preceptor">
                                                        <i class="fas fa-user-tie"></i>
                                                    </a>
                                                    <a href="{{ route('cursos.agregarAlumnos', $curso->id) }}"
                                                        class="btn btn-primary" title="Agregar Alumnos">
                                                        <i class="fas fa-user-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('partials.footer')
@endsection

@section('js')
    <script>
        console.log('Página de Lista de Cursos cargada correctamente.');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection

@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
@endsection

@section('js')
    <!-- jQuery y DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Botones de exportación de DataTables -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#alumnos-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
                },
                dom: 'Bfrtip', // Botones + Filtro + Tabla + Información + Paginación
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Descargar Excel',
                    className: 'btn btn-success'
                }],
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Todos"]
                ],
                "pageLength": 10 // Establece la cantidad de filas predeterminada
            });
        });
    </script>
    <script>
        console.log('Página de lista alumnos cargada correctamente');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script>
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === 'x' || e.key === 'X')) {
                // Evita la acción por defecto (abrir nueva ventana)
                e.preventDefault();

                // Redirecciona a la ruta de "Nueva Inscripción"
                window.location.href = "{{ route('home') }}";
            }
        });
    </script>
@endsection
