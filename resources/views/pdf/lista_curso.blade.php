<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado Curso {{ $curso->nombre }} - {{ $curso->anio_lectivo }}</title>
    <style>
        @page { size: legal portrait; margin: 10mm 15mm 0mm 25mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #111; }
        h1, h2, h3 { margin: 0; padding: 0; }

        .title-bar { font-size: 14px; font-weight: 700; margin-bottom: 4px; }
        .title-bar .name { font-size: 16px; font-weight: 800; }
        .meta { font-size: 9px; color: #666; margin-bottom: 6px; }
        .small { font-size: 9px; }
        .muted { color: #666; }

        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
        .no-border, .no-border td, .no-border th { border: none !important; }

        table { width: 100%; border-collapse: collapse; }
        th, td { border: none; padding: 3px 4px; }
        th { background: #f2f2f2; font-weight: 700; }

        .t-center { text-align: center; }
        .nowrap { white-space: nowrap; }

        /* Bordes visibles solo en la tabla principal */
        .gridtable th, .gridtable td { border: 1px solid #444; }
    </style>
</head>
<body>

    {{-- Encabezado institucional (membrete) --}}
    <div class="header">
        <div class="meta">
            {{ $school['name'] }} · {{ $school['address'] }} · {{ $school['phone'] }}
        </div>
        <div class="small muted">Generado: {{ $generado ?? now()->format('d/m/Y H:i') }}</div>
    </div>

    {{-- Título --}}
    <div class="title-bar">
        Listado de Alumnos — Curso: <span class="name">{{ mb_strtoupper($curso->nombre) }}</span>
        &nbsp;|&nbsp; Año Lectivo: <strong>{{ $curso->anio_lectivo }}</strong>
    </div>

    {{-- Preceptor --}}
    <table class="no-border" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:6px;">
        <tr>
            <td style="color:#555; width:120px;">Preceptor</td>
            <td>
                <strong>
                    {{ $curso->preceptor ? ($curso->preceptor->apellido.' '.$curso->preceptor->nombre) : 'Sin asignar' }}
                </strong>
            </td>
        </tr>
    </table>

    {{-- Tabla de alumnos (con columna N°) --}}
    <table class="gridtable" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th style="width:32px;" class="t-center">N°</th>
                <th>Apellido</th>
                <th>Nombre</th>
                <th class="nowrap">DNI</th>
                <th>Tutor</th>
                <th class="nowrap">Tel. Tutor</th>
                <th class="nowrap">Tel. Alumno</th>
                <th>Previas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($curso->historialAcademico as $historial)
                @php
                    $al = $historial->alumno;
                    $p  = $previasPorAlumno[$al->id] ?? ['status'=>'ok','count'=>0,'preview'=>''];
                @endphp
                <tr>
                    <td class="t-center">{{ $loop->iteration }}</td>
                    <td>{{ $al->apellido }}</td>
                    <td>{{ $al->nombre }}</td>
                    <td class="nowrap">{{ $al->dni }}</td>
                    <td>{{ trim(($al->apellido_tutor ?? '').' '.($al->nombre_tutor ?? '')) ?: '—' }}</td>
                    <td class="nowrap">{{ $al->celular_tutor ?? '—' }}</td>
                    <td class="nowrap">{{ $al->telefono ?? '—' }}</td>
                    <td>
                        @if ($p['status'] === 'faltan')
                            Faltan notas
                        @elseif ($p['count'] > 0)
                            {{ $p['count'] }} {{ $p['preview'] ? '('.$p['preview'].')' : '' }}
                        @else
                            Sin adeudadas
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
