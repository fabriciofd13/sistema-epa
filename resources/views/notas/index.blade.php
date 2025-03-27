{{-- @extends('adminlte::page')

@section('title', 'Cursos para Carga de Notas')

@section('content_header')
    <h1>Cursos para Carga de Notas</h1>
@endsection

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cursos as $curso)
                    <tr>
                        <td>{{ $curso->nombre }}</td>
                        <td><a href="{{ route('notas.show', $curso->id) }}" class="btn btn-primary">Agregar Notas</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @include('partials.footer')
@endsection
 --}}

 {{-- @extends('adminlte::page')

@section('title', 'Cursos para Carga de Notas')

@section('content_header')
    <h1>Cursos para Carga de Notas</h1>
@endsection

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cursos as $curso)
                    <tr>
                        <td>{{ $curso->nombre }}</td>
                        <td>
                            <a href="{{ route('notas.show', $curso->id) }}" class="btn btn-primary">Agregar Notas</a>
                            
                            <!-- Botones para acceder a la carga de cada etapa -->
                            <div class="btn-group">
                                <a href="{{ route('notas.carga_etapa', ['curso_id' => $curso->id, 'etapa' => 'primer_trimestre']) }}" class="btn btn-success">1° Trimestre</a>
                                <a href="{{ route('notas.carga_etapa', ['curso_id' => $curso->id, 'etapa' => 'segundo_trimestre']) }}" class="btn btn-warning">2° Trimestre</a>
                                <a href="{{ route('notas.carga_etapa', ['curso_id' => $curso->id, 'etapa' => 'tercer_trimestre']) }}" class="btn btn-info">3° Trimestre</a>
                                <a href="{{ route('notas.carga_etapa', ['curso_id' => $curso->id, 'etapa' => 'nota_final']) }}" class="btn btn-dark">Nota Final</a>
                                <a href="{{ route('notas.carga_etapa', ['curso_id' => $curso->id, 'etapa' => 'nota_diciembre']) }}" class="btn btn-secondary">Diciembre</a>
                                <a href="{{ route('notas.carga_etapa', ['curso_id' => $curso->id, 'etapa' => 'nota_febrero']) }}" class="btn btn-secondary">Febrero</a>
                                <a href="{{ route('notas.carga_etapa', ['curso_id' => $curso->id, 'etapa' => 'previa']) }}" class="btn btn-danger">Previas</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('partials.footer')
@endsection --}}
@extends('adminlte::page')

@section('title', 'Página en Construcción')

@section('content_header')
<div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Planillas de Notas</strong></span>            
        </h4>
        <div class="d-flex">
            <a href="{{ route('home') }}" title="Volver" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container text-center">
        <div class="card p-5">
            <h2>Estamos trabajando en esta sección</h2>
            <p class="mt-3">
                ¡Vuelve más tarde para ver las nuevas funciones!
            </p>
            <img 
                src="https://cdn-icons-png.flaticon.com/512/2452/2452304.png" 
                alt="En Construcción"
                style="max-width: 200px;"
            />
        </div>
        @include('partials.footer')
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('js')
    <script>
        console.log('Página en construcción cargada');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection

