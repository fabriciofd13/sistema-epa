@extends('adminlte::page')

@section('title', 'Cargar Notas - ' . ucfirst(str_replace('_', ' ', $etapa)) . ' | REGLA')

@section('content_header')
    <h1>Cargar {{ ucfirst(str_replace('_', ' ', $etapa)) }} para {{ $curso->nombre }}</h1>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        /* Contenedor con scroll */
        .table-container {
            max-height: 500px;
            overflow: auto;
            font-size: 11px;
        }

        /* Tabla */
        .table-excel {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            /* Mantiene el tamaño de las celdas sin que se deformen */
            font-size: 11px;
        }

        /* Fila superior de materias */
        .table-excel thead th {
            writing-mode: vertical-rl;
            /* Texto en vertical de arriba hacia abajo */
            transform: rotate(180deg);
            /* Ajusta la dirección del texto */
            text-align: center;
            white-space: nowrap;
            padding: 10px;
            height: 150px;
            vertical-align: middle;
            border: 1px solid #000;
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 10;
            width: 55px;
            /* Ajuste del ancho de las columnas de materias */
            overflow: hidden;
            /* Evita que el texto sobresalga */
            text-overflow: ellipsis;
            /* Agrega puntos suspensivos si el texto es muy largo */
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
            font-size: 11px;
        }

        /* Fijar la primera columna (Nombres de alumnos) */
        .table-excel tbody td:first-child,
        .table-excel thead th:first-child {
            position: sticky;
            left: 0;
            background-color: #fff;
            z-index: 10;
            width: 180px;
            /* Hace la columna de nombres más ancha */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 11px;
        }

        /* Ajustar el ancho de las columnas de materias */
        .table-excel th,
        .table-excel td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            width: 80px;
            /* Ancho de las columnas de materias */
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 11px;
        }
    </style>


@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <form id="notasForm" action="{{ route('notas.guardar_etapa', ['curso_id' => $curso->id, 'etapa' => $etapa]) }}"
            method="POST" autocomplete="off">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered table-excel">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            @foreach ($materias as $materia)
                                <th>{{ $materia->nombre }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historiales as $historial)
                            @php
                                $alumno = $historial->alumno;
                            @endphp
                            <tr>
                                <td>{{ $alumno->apellido }}, {{ $alumno->nombre }}</td>
                                @foreach ($materias as $materia)
                                    @php
                                        $nota = $notas[$historial->id . '-' . $materia->id] ?? null;
                                    @endphp
                                    <td>
                                        <input type="text" name="notas[{{ $historial->id }}][{{ $materia->id }}]"
                                            class="form-control nota-input"
                                            value="{{ isset($nota) && $nota->$etapa !== null ? intval($nota->$etapa) : '' }}">

                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <button type="submit" class="btn btn-success">Guardar Notas</button>
        </form>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputs = Array.from(document.querySelectorAll(".nota-input"));

            function actualizarColor(input) {
                const valor = input.value.trim();
                input.dataset.value = valor; // Actualiza el atributo data-value

                if (["1", "2", "3"].includes(valor)) {
                    input.style.color = "red";
                } else if (["4", "5"].includes(valor)) {
                    input.style.color = "green";
                } else if (["6", "7", "8", "9", "10"].includes(valor)) {
                    input.style.color = "black";
                } else {
                    input.style.color = "";
                }
            }

            function validarEntrada(event) {
                const input = event.target;
                let valor = input.value.replace(/[^0-9]/g, '');

                if (valor !== "" && (valor < 1 || valor > 10)) {
                    valor = "";
                }

                input.value = valor;
                actualizarColor(input);
            }

            inputs.forEach(input => {
                actualizarColor(input);
                input.addEventListener("input", validarEntrada);
            });

            inputs.forEach((input, index) => {
                input.addEventListener("keydown", (e) => {
                    const colCount = inputs.length / {{ count($historiales) }};
                    const currentIndex = inputs.indexOf(e.target);

                    switch (e.key) {
                        case "ArrowUp":
                            e.preventDefault();
                            if (currentIndex - colCount >= 0) {
                                inputs[currentIndex - colCount].focus();
                            }
                            break;
                        case "ArrowDown":
                            e.preventDefault();
                            if (currentIndex + colCount < inputs.length) {
                                inputs[currentIndex + colCount].focus();
                            }
                            break;
                        case "ArrowLeft":
                            e.preventDefault();
                            if (currentIndex > 0) {
                                inputs[currentIndex - 1].focus();
                            }
                            break;
                        case "ArrowRight":
                        case "Tab":
                            e.preventDefault();
                            if (currentIndex < inputs.length - 1) {
                                inputs[currentIndex + 1].focus();
                            }
                            break;
                        case "Enter":
                            e.preventDefault();
                            if (currentIndex + colCount < inputs.length) {
                                inputs[currentIndex + colCount].focus();
                            }
                            break;
                    }
                });
            });

            document.addEventListener("keydown", function(e) {
                if (e.ctrlKey && e.key === "g") {
                    e.preventDefault();
                    document.getElementById("notasForm").submit();
                }
            });
        });
    </script>
@endsection
