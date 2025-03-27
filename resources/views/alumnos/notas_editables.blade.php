@extends('adminlte::page')

@section('title', 'Editar Notas de ' . $alumno->nombre . ' ' . $alumno->apellido)

@section('content_header')
    <h1>Editar Notas de {{ $alumno->nombre }} {{ $alumno->apellido }} - {{ $curso->nombre ?? 'Curso no asignado' }}</h1>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <form id="notasForm" action="{{ route('alumnos.notas.guardar', $alumno->id) }}" method="POST">
            @csrf
            <table class="table table-excel">
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
                            $nota = $notas[$materia->id] ?? null;
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
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
        </form>
        <a href="{{ route('alumnos.index') }}" class="btn btn-secondary mt-3">Volver</a>
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
                    const colCount = 7; // Cantidad de columnas de notas
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
