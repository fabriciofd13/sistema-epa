@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Panel Principal</strong></span>
        </h4>
    </div>
@endsection

@section('content')
    <div class="wrapper d-flex flex-column min-vh-100">
        <div class="container">
            <!-- Inicio de fila para las cards -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                <!-- Card: Nuevo Alumno -->
                <div class="col">
                    <div class="card h-100 text-center">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-user-plus fa-2x mb-3"></i>
                            <h5 class="card-title">Nuevo Alumno</h5>
                            <p class="card-text">Registra un nuevo estudiante en el sistema.</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('alumnos.create') }}" class="btn btn-primary w-100">
                                Ir a Nuevo Alumno
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card: Lista de Alumnos -->
                <div class="col">
                    <div class="card h-100 text-center">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-list fa-2x mb-3"></i>
                            <h5 class="card-title">Lista de Alumnos</h5>
                            <p class="card-text">Consulta el listado de todos los alumnos registrados.</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('alumnos.index') }}" class="btn btn-secondary w-100">
                                Ver Lista
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card: Cursos -->
                <div class="col">
                    <div class="card h-100 text-center">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-chalkboard-teacher fa-2x mb-3"></i>
                            <h5 class="card-title">Cursos</h5>
                            <p class="card-text">Gestiona los cursos disponibles en la institución.</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('cursos.index') }}" class="btn btn-success w-100">
                                Ir a Cursos
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card: Notas -->
                <div class="col">
                    <div class="card h-100 text-center">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-list fa-2x mb-3"></i>
                            <h5 class="card-title">Notas</h5>
                            <p class="card-text">Revisa y administra las calificaciones de los alumnos.</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('notas.index') }}" class="btn btn-light w-100">
                                Ver Notas
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card: Nuevo Docente -->
                <div class="col">
                    <div class="card h-100 text-center">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-user-tie fa-2x mb-3"></i>
                            <h5 class="card-title">Nuevo Docente</h5>
                            <p class="card-text">Agrega un nuevo miembro al cuerpo docente.</p>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6"><a href="{{route('docentes.create')}}" class="btn btn-warning w-100">
                                        Nuevo Docente
                                    </a></div>
                                <div class="col-md-6"><a href="{{route('preceptors.create')}}" class="btn btn-danger w-100">
                                        Nuevo Preceptor
                                    </a></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Materias -->
                <div class="col">
                    <div class="card h-100 text-center">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-book fa-2x mb-3"></i>
                            <h5 class="card-title">Materias</h5>
                            <p class="card-text">Administra las materias ofrecidas en la institución.</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('materias.index')}}" class="btn btn-danger w-100">
                                Ver Materias
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Fin de fila para las cards -->
        </div>

        {{-- Incluir el footer parcial --}}
        @include('partials.footer')
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('js')
    <script>
        console.log('Página de inicio cargada correctamente');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
