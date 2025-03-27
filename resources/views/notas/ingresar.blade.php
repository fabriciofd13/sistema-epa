@extends('adminlte::page')

@section('title', 'Notas ' . $materia->nombre . ' - ' . $curso->nombre)

@section('content_header')
    <h1>Cargar Notas para {{ $materia->nombre }} en {{ $curso->nombre }}</h1>
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
        <form id="notasForm" action="{{ route('notas.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_materia" value="{{ $materia->id }}">
            <input type="hidden" name="id_curso" value="{{ $curso->id }}">
            <table class="table table-excel">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>1er Trim</th>
                        <th>2do Trim</th>
                        <th>3er Trim</th>
                        <th>Final</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnos as $alumno)
                        <tr>
                            <td>{{ $alumno->apellido }}, {{ $alumno->nombre }}</td>
                            <td>
                                <input type="text" name="notas[{{ $alumno->id }}][primer_trimestre]"
                                    class="form-control nota-input"
                                    value="{{ $alumno->notas->first()->primer_trimestre ?? '' }}">
                            </td>
                            <td>
                                <input type="text" name="notas[{{ $alumno->id }}][segundo_trimestre]"
                                    class="form-control nota-input"
                                    value="{{ $alumno->notas->first()->segundo_trimestre ?? '' }}">
                            </td>
                            <td>
                                <input type="text" name="notas[{{ $alumno->id }}][tercer_trimestre]"
                                    class="form-control nota-input"
                                    value="{{ $alumno->notas->first()->tercer_trimestre ?? '' }}">
                            </td>
                            <td>
                                <input type="text" name="notas[{{ $alumno->id }}][nota_final]"
                                    class="form-control nota-input"
                                    value="{{ $alumno->notas->first()->nota_final ?? '' }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Guardar Notas</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = Array.from(document.querySelectorAll('.nota-input'));

            inputs.forEach((input, index) => {
                input.addEventListener('keydown', (e) => {
                    const colCount = 4; // Cantidad de columnas de notas
                    const currentIndex = inputs.indexOf(e.target);

                    switch (e.key) {
                        case 'ArrowUp':
                            e.preventDefault();
                            if (currentIndex - colCount >= 0) {
                                inputs[currentIndex - colCount].focus();
                            }
                            break;
                        case 'ArrowDown':
                            e.preventDefault();
                            if (currentIndex + colCount < inputs.length) {
                                inputs[currentIndex + colCount].focus();
                            }
                            break;
                        case 'ArrowLeft':
                            e.preventDefault();
                            if (currentIndex > 0) {
                                inputs[currentIndex - 1].focus();
                            }
                            break;
                        case 'ArrowRight':
                        case 'Tab':
                            e.preventDefault();
                            if (currentIndex < inputs.length - 1) {
                                inputs[currentIndex + 1].focus();
                            }
                            break;
                        case 'Enter':
                            e.preventDefault();
                            if (currentIndex + colCount < inputs.length) {
                                inputs[currentIndex + colCount].focus();
                            }
                            break;
                    }
                });
            });

            // Guardar formulario con Ctrl + G
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'g') {
                    e.preventDefault();
                    document.getElementById('notasForm').submit();
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputs = document.querySelectorAll(".table-excel input");

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
                    input.style.color = ""; // Restaura el color predeterminado si es un valor inválido
                }
            }

            function validarEntrada(event) {
                const input = event.target;
                let valor = input.value.replace(/[^0-9]/g, ''); // Elimina caracteres no numéricos

                if (valor !== "" && (valor < 1 || valor > 10)) {
                    valor = ""; // Si el número es menor a 1 o mayor a 10, lo borra
                }

                input.value = valor; // Asigna el valor validado
                actualizarColor(input);
            }

            // Aplicar validaciones a todos los inputs
            inputs.forEach(input => {
                actualizarColor(input);
                input.addEventListener("input", validarEntrada);
            });
        });
    </script>


    @include('partials.footer')
@endsection
