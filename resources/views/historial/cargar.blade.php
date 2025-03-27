@extends('adminlte::page')

@section('title', 'Notas de ' . $alumno->nombre . ' ' . $alumno->apellido)

@section('content_header')
    {{-- <h3>Notas de {{ $alumno->nombre }} {{ $alumno->apellido }} - {{ $curso->nombre }}</h3> --}}
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light">Notas</span>
            <span class="badge bg-light border border-secondary"><strong>{{ $alumno->nombre }}
                    {{ $alumno->apellido }}</strong></span>
            <span class="badge bg-light border border-secondary">{{ $curso->nombre }}({{ $curso->anio_lectivo }})</span>
        </h4>
        <div class="d-flex">
            <button type="submit" form="notasForm" class="btn btn-outline-success me-2">
                <i class="fas fa-save"></i> Guardar
                <span class="badge bg-light text-success border border-success ms-2">Ctrl + G</span>
            </button>
            <a href="{{ route('historial.index', $alumno->id) }}"
                class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        /* Contenedor con scroll */
        .table-container {
            max-height: 500px;
            overflow: auto;
            position: relative;
        }

        /* Tabla estilo Excel */
        .table-excel {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            font-size: 12px;
        }

        /* Fila superior de materias */
        .table-excel thead th {
            writing-mode: vertical-lr;
            transform: rotate(180deg);
            text-align: center;
            padding: 10px;
            height: 150px;
            vertical-align: middle;
            border: 1px solid #000;
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 10;
            width: 80px;
            white-space: normal;
            overflow-wrap: break-word;
        }

        /* Fijar la primera columna (Nombres de alumnos) */
        .table-excel tbody td:first-child,
        .table-excel thead th:first-child {
            position: sticky;
            left: 0;
            background-color: #fff;
            z-index: 10;
            width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Estilos generales de celdas */
        .table-excel th,
        .table-excel td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            width: 100px;
        }

        /* Estilo para los inputs */
        .nota-input {
            width: 100%;
            text-align: center;
            border: none;
            outline: none;
            background: transparent;
            font-size: 1rem;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <form id="notasForm"
            action="{{ route('historial.guardarNotas', ['alumno' => $alumno->id, 'id_historial' => $historial->id]) }}"
            method="POST">
            @csrf
            <div class="table-container">
                <table class="table table-bordered table-excel">
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>1er Trimestre</th>
                            <th>2do Trimestre</th>
                            <th>3er Trimestre</th>
                            <th>Nota Anual</th>
                            <th>Diciembre</th>
                            <th>Febrero</th>
                            <th>Previas</th>
                            <th>Definitiva</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materias as $materia)
                            @php
                                $nota = $notas->get($materia->id);
                            @endphp
                            <tr>
                                <td>{{ $materia->nombre }}</td>
                                @foreach (['primer_trimestre', 'segundo_trimestre', 'tercer_trimestre', 'nota_final', 'nota_diciembre', 'nota_febrero', 'previa', 'definitiva'] as $campo)
                                    <td>
                                        <input type="text" name="notas[{{ $materia->id }}][{{ $campo }}]"
                                            class="form-control nota-input" value="{{ $nota->$campo ?? '' }}">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-success mt-3 mb-3"hidden>Guardar Notas</button>
        </form>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputs = Array.from(document.querySelectorAll(".nota-input"));

            function actualizarColor(input) {
                const valor = input.value.trim();
                input.dataset.value = valor;

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
                    const colCount = inputs.length / {{ count($materias) }};
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
                if (e.ctrlKey && e.key === "g" || e.key === "G") {
                    e.preventDefault();
                    document.getElementById("notasForm").submit();
                }
                if ((e.ctrlKey || e.metaKey) && (e.key === 'x' || e.key === 'X')) {
                    // Evita la acción por defecto (abrir nueva ventana)
                    e.preventDefault();

                    window.location.href =
                        "{{ route('historial.index', $alumno->id) }}";
                }
            });
        });
    </script>
@endsection
