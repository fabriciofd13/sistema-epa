@extends('adminlte::page')

@section('title', 'Ficha del Alumno | REGLA')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary">
                <strong>Ficha del Alumno</strong>
            </span>
        </h4>
        <div class="d-flex flex-wrap gap-2">

            {{-- Volver a lista de alumnos --}}
            <a href="{{ route('alumnos.index') }}" title="Lista de Alumnos" class="btn btn-outline-primary me-2">
                <i class="fas fa-list"></i> Lista
            </a>

            {{-- Editar datos del alumno --}}
            <a href="{{ route('alumnos.edit', $alumno->id) }}" class="btn btn-outline-warning me-2">
                <i class="fas fa-edit"></i> Editar
            </a>

            {{-- Inscripciones --}}
            <a href="{{ route('historial.index', $alumno->id) }}" class="btn btn-outline-primary me-2"
                title="Ver Inscripciones">
                <i class="fas fa-file-alt"></i> Inscripciones
            </a>

            {{-- Cooperadora --}}
            <a href="{{ route('historial.editarCooperadora', $alumno->id) }}" title="Actualizar Pago Cooperadora"
                class="btn btn-outline-success me-2">
                <i class="fas fa-money-bill"></i> Cooperadora
            </a>

            {{-- Imprimir ficha --}}
            <a href="{{ route('alumnos.ficha.pdf', $alumno->id) }}" target="_blank" title="Imprimir Ficha Académica"
                class="btn btn-outline-dark me-2">
                <i class="fas fa-print"></i> Imprimir
            </a>
            {{-- Volver al Home --}}
            <a href="{{ route('home') }}" title="Volver" class="btn btn-outline-secondary me-2">
                <i class="fas fa-times"></i> Volver
            </a>
        </div>
    </div>
@endsection


@section('content')
    <div class="container-fluid">
        {{-- Encabezado --}}
        <div class="card mb-3">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    @if (!empty($fotoUrl))
                        <img src="{{ $fotoUrl }}" alt="Foto del alumno" class="img-thumbnail"
                            style="width: 110px; height: 110px; object-fit: cover;">
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center text-white rounded"
                            style="width: 110px; height:110px;">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-grow-1 ml-4">
                    <h3 class="mb-1">
                        {{ $alumno->apellido ?? '' }}, {{ $alumno->nombre ?? '' }}
                    </h3>
                    <div class="text-muted">
                        <span class="me-3"><i class="far fa-id-card"></i> DNI:
                            <strong>{{ $alumno->dni ?? '-' }}</strong></span>
                        @if (!empty($alumno->cuil))
                            <span class="me-3 ml-3"><i class="fas fa-id-card-alt"></i> CUIL:
                                <strong>{{ $alumno->cuil }}</strong></span>
                        @endif
                        @if (!empty($alumno->fecha_inscripcion))
                            <span class="me-3 ml-3"><i class="far fa-calendar-check"></i> Inscripción:
                                <strong>{{ \Carbon\Carbon::parse($alumno->fecha_inscripcion)->format('d/m/Y') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Datos personales / Contacto / Situación actual --}}
        <div class="row">
            {{-- Datos personales --}}
            <div class="col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white"><i class="fas fa-user"></i> Datos Personales</div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-5">Apellido</dt>
                            <dd class="col-7">{{ $alumno->apellido ?? '-' }}</dd>
                            <dt class="col-5">Nombre</dt>
                            <dd class="col-7">{{ $alumno->nombre ?? '-' }}</dd>
                            <dt class="col-5">DNI</dt>
                            <dd class="col-7">{{ $alumno->dni ?? '-' }}</dd>
                            @if (!empty($alumno->fecha_nacimiento))
                                <dt class="col-5">Nacimiento</dt>
                                <dd class="col-7">{{ \Carbon\Carbon::parse($alumno->fecha_nacimiento)->format('d/m/Y') }}
                                </dd>
                            @endif
                            {{-- Dirección completa --}}
                            @php
                                $dir = trim(($alumno->direccion ?? '') . ' ' . ($alumno->numero ?? ''));
                                $barrio = $alumno->barrio ?? null;
                                $loc = $alumno->localidad ?? null;
                            @endphp
                            @if ($dir !== '' || $barrio || $loc)
                                <dt class="col-5">Dirección</dt>
                                <dd class="col-7">
                                    {{ $dir !== '' ? $dir : '-' }}
                                    @if ($barrio)
                                        <br>Barrio: {{ $barrio }}
                                    @endif
                                    @if ($loc)
                                        <br>Localidad: {{ $loc }}
                                    @endif
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Contacto (incluye tutor) --}}
            <div class="col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-secondary text-white"><i class="fas fa-phone"></i> Contacto</div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            @if (!empty($alumno->telefono))
                                <dt class="col-5">Teléfono</dt>
                                <dd class="col-7">{{ $alumno->telefono }}</dd>
                            @endif
                            @if (!empty($alumno->celular))
                                <dt class="col-5">Celular</dt>
                                <dd class="col-7">{{ $alumno->celular }}</dd>
                            @endif
                            @if (!empty($alumno->email))
                                <dt class="col-5">Email</dt>
                                <dd class="col-7">{{ $alumno->email }}</dd>
                            @endif

                            <hr class="my-2">

                            {{-- Tutor --}}
                            @php
                                $tutorNombre = trim(
                                    ($alumno->apellido_tutor ?? '') . ' ' . ($alumno->nombre_tutor ?? ''),
                                );
                            @endphp
                            <dt class="col-12"><strong><i class="fas fa-user-shield"></i> Tutor</strong></dt>
                            <br>
                            @if ($tutorNombre !== '')
                                <dt class="col-5">Apellido y Nombre</dt>
                                <dd class="col-7">{{ $tutorNombre }}</dd>
                            @endif
                            @if (!empty($alumno->dni_tutor))
                                <dt class="col-5">DNI Tutor</dt>
                                <dd class="col-7">{{ $alumno->dni_tutor }}</dd>
                            @endif
                            @if (!empty($alumno->celular_tutor))
                                <dt class="col-5">Celular Tutor</dt>
                                <dd class="col-7">{{ $alumno->celular_tutor }}</dd>
                            @endif
                            @if (!empty($alumno->parentesco_tutor))
                                <dt class="col-5">Parentesco</dt>
                                <dd class="col-7">{{ $alumno->parentesco_tutor }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Situación Académica Actual (según historial del año actual) --}}
            <div class="col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-school"></i> Situación Académica Actual
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-5">Año lectivo</dt>
                            <dd class="col-7">{{ $cursoActual->anio ?? date('Y') }}</dd>

                            <dt class="col-5">Curso/División</dt>
                            <dd class="col-7">{{ $cursoActual->curso_nombre ?? 'No inscripto' }}</dd>

                            @if (!empty($preceptorActual))
                                <dt class="col-5">Preceptor/a</dt>
                                <dd class="col-7">
                                    {{ ($preceptorActual->apellido ?? '') . ' ' . ($preceptorActual->nombre ?? '') }}
                                </dd>
                            @endif
                            <hr class="my-2">

                            {{-- Año lectivo anterior --}}
                            <dt class="col-5">Año lectivo anterior</dt>
                            <dd class="col-7">{{ $cursoAnterior->anio ?? date('Y') - 1 }}</dd>

                            <dt class="col-5">Curso anterior</dt>
                            <dd class="col-7">{{ $cursoAnterior->curso_nombre ?? '—' }}</dd>
                            <hr class="my-2">

                            {{-- Previas (años anteriores) --}}
                            <dt class="col-5">Previas</dt>
                            <dd class="col-7">
                                @if ($previasStatus === 'faltan')
                                    <span class="badge bg-warning text-dark"
                                        title="Faltan cargar notas en años anteriores">
                                        Faltan notas
                                    </span>
                                @elseif ($previasCount > 0)
                                    <span class="badge bg-danger" title="Materias adeudadas en años anteriores">
                                        {{ $previasCount }}
                                    </span>
                                    @if (!empty($previasPreview))
                                        <br><small class="text-muted">{{ $previasPreview }}</small>
                                    @endif
                                @else
                                    <span class="text-muted">Sin materias adeudadas</span>
                                @endif
                            </dd>


                        </dl>
                    </div>
                </div>
            </div>

        </div>
        {{-- Historial Académico por Año --}}
        <div class="card mt-3">
            <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
                <span><i class="fas fa-stream"></i> Historial Académico</span>
                <small class="text-light">Notas coloreadas: 1–3 rojo, 4–5 verde, 6–10 negro</small>
            </div>

            <div class="card-body">
                @if (empty($notasPorAnio) || count($notasPorAnio) === 0)
                    <div class="alert alert-info mb-0">No hay notas registradas.</div>
                @else
                    <div class="accordion" id="accordionHistorial">
                        @foreach ($notasPorAnio as $anioLectivo => $filas)
                            @php
                                // Ordenar materias alfabéticamente si viene como colección/array de objetos
                                if ($filas instanceof \Illuminate\Support\Collection) {
                                    $filas = $filas
                                        ->sortBy(fn($f) => mb_strtoupper($f->materia ?? ($f['materia'] ?? '')))
                                        ->values();
                                } elseif (is_array($filas)) {
                                    usort($filas, function ($a, $b) {
                                        $ma = mb_strtoupper(is_array($a) ? $a['materia'] ?? '' : $a->materia ?? '');
                                        $mb = mb_strtoupper(is_array($b) ? $b['materia'] ?? '' : $b->materia ?? '');
                                        return $ma <=> $mb;
                                    });
                                }
                            @endphp

                            <div class="accordion-item mb-2">
                                <h2 class="accordion-header" id="heading-{{ $anioLectivo }}">
                                    <button class="accordion-button {{ !$loop->first ? 'collapsed' : '' }}"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{ $anioLectivo }}"
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                        aria-controls="collapse-{{ $anioLectivo }}">
                                        Año lectivo {{ $anioLectivo }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $anioLectivo }}"
                                    class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                    aria-labelledby="heading-{{ $anioLectivo }}" data-bs-parent="#accordionHistorial">
                                    <div class="accordion-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered align-middle table-notas mb-0">
                                                <thead class="table-light">
                                                    <tr class="text-center">
                                                        <th class="text-start" style="min-width:220px;">Materia</th>
                                                        <th>1° Trim</th>
                                                        <th>2° Trim</th>
                                                        <th>3° Trim</th>
                                                        <th>Prom.</th>
                                                        <th>Final</th>
                                                        <th>Dic.</th>
                                                        <th>Feb.</th>
                                                        <th>Previas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($filas as $fila)
                                                        @php
                                                            // Permite acceder como objeto o array
                                                            $get = function ($key) use ($fila) {
                                                                if (is_array($fila)) {
                                                                    return $fila[$key] ?? null;
                                                                }
                                                                return $fila->$key ?? null;
                                                            };
                                                        @endphp
                                                        <tr>
                                                            <td class="text-start fw-semibold">
                                                                {{ $get('materia') ?? '-' }}</td>
                                                            <td class="nota">{{ $get('primer_trimestre') }}</td>
                                                            <td class="nota">{{ $get('segundo_trimestre') }}</td>
                                                            <td class="nota">{{ $get('tercer_trimestre') }}</td>
                                                            <td class="nota">{{ $get('promedio') }}</td>
                                                            <td class="nota">{{ $get('nota_final') }}</td>
                                                            <td class="nota">{{ $get('diciembre') }}</td>
                                                            <td class="nota">{{ $get('febrero') }}</td>
                                                            <td class="nota">{{ $get('previas') }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center text-muted">Sin
                                                                registros</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- Leyenda opcional --}}
                                        <div class="mt-2 small text-muted">
                                            <i class="fas fa-info-circle"></i> Las celdas vacías indican que no se registró
                                            nota para esa instancia.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Sección adicional opcional: Novedades / Asistencias / Archivos --}}
        {{-- @include('alumnos.partials.novedades', ['novedades' => $novedades ?? []]) --}}
    </div>
@endsection

@section('css')
    <style>
        /* Estilo tipo Excel para tabla de notas */
        .table-notas th,
        .table-notas td {
            vertical-align: middle;
            text-align: center;
            white-space: nowrap;
        }

        .table-notas td:first-child {
            text-align: left;
            white-space: normal;
        }

        /* Colores por nota */
        .nota.roja {
            color: #d93025;
            font-weight: 600;
        }

        /* 1 a 3 */
        .nota.verde {
            color: #188038;
            font-weight: 600;
        }

        /* 4 a 5 */
        .nota.negra {
            color: #111;
            font-weight: 600;
        }

        /* 6 a 10 */
        .nota.vacia {
            color: #6c757d;
        }

        /* sin dato */
    </style>
@endsection

@section('js')
    <script>
        /**
         * Aplica color según rango de nota:
         * 1–3 rojo, 4–5 verde, 6–10 negro; vacío/gris si no hay número válido.
         */
        (function colorizarNotas() {
            document.querySelectorAll('.table-notas td.nota').forEach(td => {
                const raw = (td.textContent || '').toString().trim();
                if (!raw) {
                    td.classList.add('vacia');
                    td.textContent = '';
                    return;
                }

                // admitir "10", "7", "6.5" si usás decimales, ajustá el parse según tu BD
                const val = Number(raw.replace(',', '.'));
                if (Number.isNaN(val)) {
                    td.classList.add('vacia');
                    return;
                }

                // redondeo opcional visual
                // td.textContent = Number.isInteger(val) ? val : val.toFixed(1);

                if (val >= 1 && val <= 3) {
                    td.classList.add('roja');
                } else if (val >= 4 && val <= 5) {
                    td.classList.add('verde');
                } else if (val >= 6 && val <= 10) {
                    td.classList.add('negra');
                } else {
                    td.classList.add('vacia');
                }
            });
        })();
    </script>
@endsection
