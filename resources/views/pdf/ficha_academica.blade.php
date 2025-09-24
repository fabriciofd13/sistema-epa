<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Ficha Académica | REGLA</title>
    <style>
        @page {
            size: legal portrait;
            /* tamaño Legal vertical */
            margin: 0m 15mm 0mm 25mm;
            /* top right bottom left */
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #111;
        }


        h1,
        h2,
        h3 {
            margin: 0;
            padding: 0;
        }

        .title-bar {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .title-bar .name {
            font-size: 16px;
            font-weight: 800;
        }

        .title-bar .dni {
            font-weight: 800;
        }

        .meta {
            font-size: 9px;
            color: #666;
            margin-bottom: 6px;
        }

        .no-border,
        .no-border td,
        .no-border th {
            border: none !important;
        }

        .small {
            font-size: 10px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .school {
            font-size: 11px;
            text-align: center;
        }

        .small {
            font-size: 9px;
        }

        .muted {
            color: #666;
        }

        /* Bloque superior dos columnas */
        .top-box {
            border: none;
            padding: 8px;
            margin-bottom: 8px;
        }

        .two-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .box-title {
            font-weight: 700;
            margin-bottom: 4px;
        }

        .grid {
            display: grid;
            grid-template-columns: 140px 1fr;
            gap: 2px 8px;
        }

        .label {
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: none
                /* 1px solid #444 */
            ;
            padding: 3px 4px;
        }

        th {
            background: #f2f2f2;
            font-weight: 700;
        }

        .t-center {
            text-align: center;
        }

        .nowrap {
            white-space: nowrap;
        }

        .year-head {
            margin-top: 8px;
            margin-bottom: 4px;
            font-weight: 700;
        }

        .sep {
            height: 6px;
        }

        .ok {
            color: #000;
        }

        /* 6 a 10 */
        .mid {
            color: #2e7d32;
        }

        /* 4 y 5 */
        .low {
            color: #c62828;
        }

        /* 1 a 3 */
    </style>
</head>

<body>
    {{-- Encabezado institucional --}}
    <div class="header">
        {{-- Línea institucional pequeña (opcional) --}}
        <div class="meta">
            {{ $school['name'] }} · {{ $school['address'] }} · {{ $school['phone'] }}
        </div>
        {{-- Título fuerte --}}
        <div class="title-bar">
            Historial Académico
            <span class="name">{{ mb_strtoupper($alumno->apellido) }}, {{ mb_strtoupper($alumno->nombre) }}</span>
        </div>
        {{-- Resumen compacto en 2 columnas (sin líneas) --}}
        <table class="no-border" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:6px;">
            <tr>
                {{-- Columna izquierda: datos personales mínimos --}}
                <td width="62%" valign="top">
                    <table class="no-border" width="100%" cellspacing="0" cellpadding="1" style="font-size:10px;">
                        <tr>
                            <td style="color:#555; width:120px;">DNI</td>
                            <td><strong>{{ $alumno->dni }}</strong></td>
                        </tr>
                        <tr>
                            <td style="color:#555;">Nacimiento</td>
                            <td>
                                @if ($alumno->fecha_nacimiento)
                                    {{ \Carbon\Carbon::parse($alumno->fecha_nacimiento)->format('d/m/Y') }}
                                    @if (!is_null($edad))
                                        ({{ $edad }} años)
                                    @endif
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="color:#555;">Celular</td>
                            <td>{{ $alumno->celular ?: '-' }}</td>
                        </tr>
                    </table>
                </td>

                {{-- Columna derecha: tutor compacto ocupando el ancho --}}
                <td width="38%" valign="top">
                    <table class="no-border" width="100%" cellspacing="0" cellpadding="1" style="font-size:10px;">
                        <tr>
                            <td style="color:#555; width:70px;">Tutor</td>
                            <td><strong>{{ trim($alumno->apellido_tutor . ' ' . $alumno->nombre_tutor) ?: '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="color:#555;">Parentesco</td>
                            <td>{{ $alumno->parentesco_tutor ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td style="color:#555;">Celular</td>
                            <td>{{ $alumno->celular_tutor ?: '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        @php
            $rel = $alumno->relationLoaded('historialAcademico') ? 'historialAcademico' : 'historiales';
            // Filtrar desde 2020 y ordenar por año DESC
            $hist = collect($alumno->$rel ?? [])
                ->where('anio_lectivo', '>=', $desde ?? 2020)
                ->sortByDesc('anio_lectivo')
                ->values();

            // Partir en filas de 2 (cada fila = 2 columnas = 2 años)
            $chunks = $hist->chunk(2);

            $fmt = function ($v) {
                if ($v === null || $v === '') {
                    return '';
                }
                $num = floatval($v);
                $cls = $num <= 3 ? 'low' : ($num <= 5 ? 'mid' : 'ok');
                return '<span class="' .
                    $cls .
                    '">' .
                    rtrim(rtrim(number_format($num, 2, ',', '.'), '0'), ',') .
                    '</span>';
            };
        @endphp

        @forelse($chunks as $row)
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:8px;">
                <tr>
                    @for ($i = 0; $i < 2; $i++)
                        @php $h = $row->get($i); @endphp
                        <td width="50%" valign="top" style="padding-{{ $i === 0 ? 'right' : 'left' }}:6px;">
                            @if ($h)
                                {{-- Encabezado del ciclo lectivo --}}
                                <div style="font-weight:700; margin:4px 0;">
                                    Curso: {{ optional($h->curso)->nombre }} &nbsp;&nbsp; Año: {{ $h->anio_lectivo }}
                                </div>

                                {{-- Tabla de materias (ordenadas al revés por nombre) --}}
                                @php
                                    $notasOrdenadas = collect($h->notas)
                                        ->sortByDesc(function ($n) {
                                            return $n->materia?->nombre ?? '';
                                        })
                                        ->values();
                                @endphp

                                <table width="100%" cellspacing="0" cellpadding="2"
                                    style="font-size:7.5px; border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th
                                                style="border:1px solid #444; background:#f2f2f2; padding:3px 4px; text-align:left;">
                                                Materia</th>
                                            <th style="border:1px solid #444; background:#f2f2f2; padding:3px 4px;"
                                                class="t-center nowrap">1°T</th>
                                            <th style="border:1px solid #444; background:#f2f2f2; padding:3px 4px;"
                                                class="t-center nowrap">2°T</th>
                                            <th style="border:1px solid #444; background:#f2f2f2; padding:3px 4px;"
                                                class="t-center nowrap">3°T</th>
                                            <th style="border:1px solid #444; background:#f2f2f2; padding:3px 4px;"
                                                class="t-center nowrap">Final</th>
                                            <th style="border:1px solid #444; background:#f2f2f2; padding:3px 4px;"
                                                class="t-center nowrap">Dic</th>
                                            <th style="border:1px solid #444; background:#f2f2f2; padding:3px 4px;"
                                                class="t-center nowrap">Feb</th>
                                            <th style="border:1px solid #444; background:#f2f2f2; padding:3px 4px;"
                                                class="t-center nowrap">Previa</th>
                                            <th style="border:1px solid #444; background:#f2f2f2; padding:3px 4px;"
                                                class="t-center nowrap">Def.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($notasOrdenadas as $n)
                                            <tr>
                                                <td style="border:1px solid #444; padding:3px 4px;">
                                                    {{ $n->materia?->nombre }}</td>
                                                <td style="border:1px solid #444; padding:3px 4px;" class="t-center">
                                                    {!! $fmt($n->primer_trimestre) !!}</td>
                                                <td style="border:1px solid #444; padding:3px 4px;" class="t-center">
                                                    {!! $fmt($n->segundo_trimestre) !!}</td>
                                                <td style="border:1px solid #444; padding:3px 4px;" class="t-center">
                                                    {!! $fmt($n->tercer_trimestre) !!}</td>
                                                <td style="border:1px solid #444; padding:3px 4px;" class="t-center">
                                                    {!! $fmt($n->nota_final) !!}</td>
                                                <td style="border:1px solid #444; padding:3px 4px;" class="t-center">
                                                    {!! $fmt($n->nota_diciembre) !!}</td>
                                                <td style="border:1px solid #444; padding:3px 4px;" class="t-center">
                                                    {!! $fmt($n->nota_febrero) !!}</td>
                                                <td style="border:1px solid #444; padding:3px 4px;" class="t-center">
                                                    {!! $fmt($n->previa) !!}</td>
                                                <td style="border:1px solid #444; padding:3px 4px;" class="t-center">
                                                    {!! $fmt($n->definitiva) !!}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9"
                                                    style="border:1px solid #444; padding:3px 4px; text-align:center; color:#666;">
                                                    Sin notas cargadas.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @endif
                        </td>
                    @endfor
                </tr>
            </table>
            @empty
                <div class="small muted">Sin historial académico desde {{ $desde ?? 2020 }}.</div>
            @endforelse

    </body>

    </html>
