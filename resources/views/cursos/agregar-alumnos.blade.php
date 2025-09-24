@extends('adminlte::page')
@section('title', 'Agregar Alumnos - ' . $curso->nombre . ' | REGLA')
@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light">Agregar Alumnos a</span>
            <span class="badge bg-light border border-secondary"><strong>{{ $curso->nombre }}</strong></span>
            <span class="badge bg-light border border-secondary"><strong>{{ $curso->anio_lectivo }}</strong></span>
        </h4>
        <div class="d-flex">
            <button type="submit" form="formActualizar" class="btn btn-outline-success me-2">
                <i class="fas fa-save"></i> Guardar Lista
            </button>
            <a href="{{ route('cursos.show', $curso->id) }}" title="Volver [Ctrl + X]" class="btn btn-outline-secondary">
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
        <div class="card p-4">
            <div class="row">
                <div class="col-md-6">
                    <h4>Alumnos inscriptos</h4>
                    <h4 class="mb-3">Preceptor:
                        {{ $curso->preceptor ? $curso->preceptor->nombre . ' ' . $curso->preceptor->apellido : 'Sin asignar' }}
                    </h4>
                    <div class="table-responsive">
                        <table id="tablaCurso" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Apellido</th>
                                    <th>Nombre</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($curso->historialAcademico as $historial)
                                    <tr>
                                        <td>{{ $historial->alumno->apellido }}</td>
                                        <td>{{ $historial->alumno->nombre }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Alumnos sin curso</h4>
                    <div class="table-responsive">
                        <table id="tablaSinCurso" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Apellido</th>
                                    <th>Nombre</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alumnosSinCurso as $alumno)
                                    <tr>
                                        <td>{{ $alumno->apellido }}</td>
                                        <td>{{ $alumno->nombre }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm agregar-btn"
                                                data-id="{{ $alumno->id }}">Agregar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <form id="formActualizar" method="POST" action="{{ route('cursos.guardarAlumnos', $curso->id) }}">
                @csrf
                <input type="hidden" name="alumnos" id="alumnosSeleccionados" value="[]">
                <button type="submit" class="btn btn-success mt-3">Guardar Lista</button>
            </form>
        </div>
    </div>
    @include('partials.footer')
@endsection

@section('js')
    <script>
        console.log('Página de Nuevo Alumno cargada correctamente.');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let alumnosSeleccionados = [];

            function inicializarDataTables() {
                let tablaSinCurso = $('#tablaSinCurso').DataTable({
                    "language": {
                        "search": "Buscar alumno:",
                        "lengthMenu": "Mostrar _MENU_ alumnos",
                        "zeroRecords": "No se encontraron alumnos",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ alumnos",
                        "infoEmpty": "No hay alumnos disponibles",
                        "infoFiltered": "(filtrado de _MAX_ alumnos en total)"
                    }
                });

                let tablaCurso = $('#tablaCurso').DataTable({
                    "paging": false,
                    "searching": false,
                    "info": false
                });

                $('#tablaSinCurso tbody').on('click', '.agregar-btn', function() {
                    let row = $(this).closest('tr');
                    let id = $(this).data('id');
                    let nombre = row.find('td:eq(1)').text();
                    let apellido = row.find('td:eq(0)').text();

                    alumnosSeleccionados.push(id);
                    tablaCurso.row.add([
                        apellido,
                        nombre,
                        `<button class='btn btn-danger btn-sm quitar-btn' data-id='${id}'>Quitar</button>`
                    ]).draw();

                    tablaSinCurso.row(row).remove().draw();
                });

                $('#tablaCurso tbody').on('click', '.quitar-btn', function() {
                    let row = $(this).closest('tr');
                    let id = $(this).data('id');
                    let nombre = row.find('td:eq(1)').text();
                    let apellido = row.find('td:eq(0)').text();

                    alumnosSeleccionados = alumnosSeleccionados.filter(a => a !== id);
                    tablaSinCurso.row.add([
                        apellido,
                        nombre,
                        `<button class='btn btn-success btn-sm agregar-btn' data-id='${id}'>Agregar</button>`
                    ]).draw();

                    tablaCurso.row(row).remove().draw();
                });

                $('#formActualizar').on('submit', function() {
                    $('#alumnosSeleccionados').val(JSON.stringify(alumnosSeleccionados));
                });
            }

            if (typeof $.fn.DataTable === 'undefined') {
                setTimeout(inicializarDataTables, 1000);
            } else {
                inicializarDataTables();
            }
        });
    </script>
    <script>
        document.addEventListener("keydown", function(e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === 'x' || e.key === 'X')) {
                // Evita la acción por defecto (abrir nueva ventana)
                e.preventDefault();

                window.location.href =
                    "{{ route('cursos.show', $curso->id) }}";
            }
        });
    </script>
@endsection
