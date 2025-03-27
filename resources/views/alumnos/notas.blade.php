@extends('adminlte::page')

@section('title', 'Notas de ' . $alumno->nombre . ' ' . $alumno->apellido)

@section('content_header')
    <h1>Notas de {{ $alumno->nombre }} {{ $alumno->apellido }} - {{ $curso->nombre ?? 'Curso no asignado' }}</h1>
@endsection

@section('content')
    <div class="container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>1er Trimestre</th>
                    <th>2do Trimestre</th>
                    <th>3er Trimestre</th>
                    <th>Nota Final</th>
                    <th>Diciembre</th>
                    <th>Febrero</th>
                    <th>Previas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notas as $nota)
                    <tr>
                        <td>{{ $nota->asignatura->nombre ?? 'Materia no asignada' }}</td>
                        <td>{{ $nota->primer_trimestre ?? '-' }}</td>
                        <td>{{ $nota->segundo_trimestre ?? '-' }}</td>
                        <td>{{ $nota->tercer_trimestre ?? '-' }}</td>
                        <td>{{ $nota->nota_final ?? '-' }}</td>
                        <td>{{ $nota->nota_diciembre ?? '-' }}</td>
                        <td>{{ $nota->nota_febrero ?? '-' }}</td>
                        <td>{{ $nota->previa ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Volver</a>
    </div>
    
    @include('partials.footer')
@endsection
@section('js')
    <script>
        console.log('Página de Carga de Notas del Alumno cargada correctamente.');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection

 