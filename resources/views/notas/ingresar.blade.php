@extends('adminlte::page')

@section('title', 'Notas ' . $materia->nombre . ' - ' . $curso->nombre)

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light">Notas</span>
            <span class="badge bg-light border border-secondary"><strong>{{ $materia->nombre }}</strong></span>
            <span class="badge bg-light border border-secondary">{{ $curso->nombre }} ({{ $curso->anio_lectivo }})</span>
        </h4>
        <div class="d-flex">
            <button type="submit" form="notasForm" class="btn btn-outline-success me-2">
                <i class="fas fa-save"></i> Guardar
                <span class="badge bg-light text-success border border-success ms-2">Ctrl + G</span>
            </button>
            <a href="{{ route('notas.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .table-container {
            /* max-height: 500px; */
            overflow: auto;
            position: relative;
        }

        .table-excel {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            font-size: 12px;
        }

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

        .table-excel th,
        .table-excel td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            width: 100px;
        }

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
        <form id="notasForm" action="{{ route('notas.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_materia" value="{{ $materia->id }}">
            <input type="hidden" name="id_curso" value="{{ $curso->id }}">
            <div class="table-container">
                <table class="table table-bordered table-excel">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            @foreach ([
                                '1er Trim' => 'primer_trimestre',
                                '2do Trim' => 'segundo_trimestre',
                                '3er Trim' => 'tercer_trimestre',
                                'Final' => 'nota_final',
                                'Diciembre' => 'nota_diciembre',
                                'Febrero' => 'nota_febrero',
                                'Previa' => 'previa',
                                'Definitiva' => 'definitiva'] as $label => $campo)
                                <th>{{ $label }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historiales as $historial)
                            @php
                                $alumno = $historial->alumno;
                                $nota = $historial->notas->first();
                            @endphp
                            <tr>
                                <td>{{ $alumno->apellido }}, {{ $alumno->nombre }}</td>
                                @foreach (['primer_trimestre', 'segundo_trimestre', 'tercer_trimestre', 'nota_final', 'nota_diciembre', 'nota_febrero', 'previa', 'definitiva'] as $campo)
                                    <td>
                                        <input type="text" name="notas[{{ $historial->id }}][{{ $campo }}]"
                                            class="nota-input"
                                            value="{{ isset($nota) && $nota->$campo !== null ? intval($nota->$campo) : '' }}"
                                            autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection

@section('js')
<script>
    console.log('Página de cargada correctamente');
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
<script src="{{ asset('js/custom.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inputs = Array.from(document.querySelectorAll(".nota-input"));

            function actualizarColor(input) {
                const valor = input.value.trim();
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
                let valor = input.value.replace(/[^0-9]/g, "");
                if (valor !== "" && (valor < 1 || valor > 10)) {
                    valor = "";
                }
                input.value = valor;
                actualizarColor(input);
            }

            inputs.forEach(input => {
                input.setAttribute("autocomplete", "off");
                actualizarColor(input);
                input.addEventListener("input", validarEntrada);
            });

            inputs.forEach((input, index) => {
                input.addEventListener("keydown", (e) => {
                    const colCount = 8;
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

            document.addEventListener("keydown", function (e) {
                if (e.ctrlKey && (e.key === "g" || e.key === "G")) {
                    e.preventDefault();
                    document.getElementById("notasForm").submit();
                }
            });
        });
    </script>
@endsection
