@extends('adminlte::page')

@section('title', 'Materias del Curso ' . $curso->nombre)

@section('content_header')
    <h1>Materias del Curso {{ $curso->nombre }}</h1>
@endsection

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($materias as $materia)
                    <tr>
                        <td>{{ $materia->nombre }}</td>
                        <td><a href="{{ route('notas.ingresar', ['curso_id' => $curso->id, 'materia_id' => $materia->id]) }}" class="btn btn-success">Seleccionar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Incluir el footer parcial --}}
    @include('partials.footer')
@endsection