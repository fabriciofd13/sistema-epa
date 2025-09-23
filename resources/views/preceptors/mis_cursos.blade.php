@extends('adminlte::page')

@section('title', 'Mis Cursos Asignados')

@section('content_header')
    <h4>Mis Cursos Asignados</h4>
@endsection

@section('content')
    <div class="container">
        <div class="card p-4">
            @if ($cursos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th>Año</th>
                                <th>Año Lectivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cursos as $curso)
                                <tr>
                                    <td>{{ $curso->nombre }}</td>
                                    <td>{{ $curso->anio }}</td>
                                    <td>{{ $curso->anio_lectivo }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('notas.carga_etapa', ['curso_id' => $curso->id, 'etapa' => 'primer_trimestre']) }}" class="btn btn-success btn-sm">1° Trimestre</a>
                                            <a href="{{ route('notas.carga_etapa', ['curso_id' => $curso->id, 'etapa' => 'segundo_trimestre']) }}" class="btn btn-warning btn-sm">2° Trimestre</a>
                                            <a href="{{ route('notas.carga_etapa', ['curso_id' => $curso->id, 'etapa' => 'tercer_trimestre']) }}" class="btn btn-info btn-sm">3° Trimestre</a>
                                            <a href="{{ route('notas.carga_etapa', ['curso_id' => $curso->id, 'etapa' => 'nota_final']) }}" class="btn btn-dark btn-sm">Nota Final</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">No tenés cursos asignados actualmente.</div>
            @endif
        </div>
        @include('partials.footer')
    </div>
@endsection
