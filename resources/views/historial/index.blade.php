@extends('adminlte::page')
@section('title', 'Inscripciones de ' . $alumno->nombre . ' ' . $alumno->apellido)
@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light">Historia Académica </span>
            <span class="badge bg-light border border-secondary"><strong>{{ $alumno->nombre }}
                    {{ $alumno->apellido }}</strong></span>
        </h4>
        <div class="d-flex">
            <a href="{{ route('historial.registrar', $alumno->id) }}" title="Nueva Inscripción [Ctrl + A]"
                class="btn btn-outline-primary me-2">
                <i class="fas fa-page"></i> Nueva Inscripción
                <span class="badge bg-light text-primary border border-primary ms-2">Ctrl + A</span>
            </a>
            <a href="{{ route('alumnos.index') }}" title="Volver [Ctrl + X]" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="card pl-4 pr-4">
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Año Lectivo</th>
                        <th>Curso</th>
                        <th>Previas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($historiales) > 0)
                        @foreach ($historiales as $historial)
                            @php
                                $materiasAdeudadas = [];
                                $todasNotasCargadas = true;
                                if ($historial->curso && $historial->curso->materias) {
                                    foreach ($historial->curso->materias as $materia) {
                                        $notaKey = $historial->id . '-' . $materia->id;
                                        $nota = $notas[$notaKey] ?? null;
                                        if (!$nota || is_null($nota->nota_final)) {
                                            $todasNotasCargadas = false;
                                            break;
                                        }
                                        if (
                                            $nota->nota_final < 6 &&
                                            ($nota->nota_diciembre < 6 || is_null($nota->nota_diciembre)) &&
                                            ($nota->nota_febrero < 6 || is_null($nota->nota_febrero)) &&
                                            ($nota->previa < 6 || is_null($nota->previa))
                                        ) {
                                            $materiasAdeudadas[] =
                                                $materia->nombre . '(' . $historial->anio_lectivo . ')';
                                        }
                                    }
                                } else {
                                    $todasNotasCargadas = false;
                                }
                            @endphp
                            <tr>
                                <td>{{ $historial->anio_lectivo }}</td>
                                <td>{{ $historial->curso->nombre ?? 'Sin curso' }}</td>
                                <td>
                                    @if (!$todasNotasCargadas)
                                        <span class="text-warning">Faltan cargar notas finales</span>
                                    @elseif (count($materiasAdeudadas) > 0)
                                        <pre class="m-0 pt-0 pb-0">{{ implode("\n", $materiasAdeudadas) }}</pre>
                                    @else
                                        <span class="text-muted">Sin materias adeudadas</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('historial.cargar', ['alumno' => $alumno->id, 'id_historial' => $historial->id]) }}"
                                        class="btn btn-info">
                                        Cargar Notas
                                    </a>

                                    {{-- Botón para Eliminar inscripción con SweetAlert2 --}}
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmarEliminacion({{ $historial->id }})">
                                        Eliminar Inscripción
                                    </button>

                                    {{-- Formulario oculto para enviar la petición DELETE --}}
                                    <form id="form-eliminar-{{ $historial->id }}"
                                        action="{{ route('historial.destroy', $historial->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="text-align: center">
                                <p>No se encuentra inscripto en ningun curso. <a
                                        href="{{ route('historial.registrar', $alumno->id) }}">Realizar inscripción</a></p>
                            </td>
                        </tr>

                    @endif
                </tbody>
            </table>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        document.addEventListener('keydown', function(e) {
            // Verifica si se presionó Ctrl + N (o Ctrl + Shift + N para algunos teclados)
            if ((e.ctrlKey || e.metaKey) && (e.key === 'a' || e.key === 'A')) {
                // Evita la acción por defecto (abrir nueva ventana)
                e.preventDefault();

                // Redirecciona a la ruta de "Nueva Inscripción"
                window.location.href = "{{ route('historial.registrar', $alumno->id) }}";
            }
            if ((e.ctrlKey || e.metaKey) && (e.key === 'x' || e.key === 'X')) {
                // Evita la acción por defecto (abrir nueva ventana)
                e.preventDefault();

                // Redirecciona a la ruta de "Nueva Inscripción"
                window.location.href = "{{ route('alumnos.index') }}";
            }
        });
    </script>
    
    
    <script>
        function confirmarEliminacion(historialId) {
            Swal.fire({
                title: '¿Eliminar inscripción?',
                text: "Esta acción borrará todas las notas asociadas al historial (curso y año lectivo).",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Envía el formulario oculto
                    document.getElementById(`form-eliminar-${historialId}`).submit();
                }
            });
        }
    </script>
@endsection
