@extends('adminlte::page')

@section('title', 'Preceptores | REGLA')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Preceptores</strong></span>
        </h4>
        <div class="d-flex">
            <a href="{{ route('preceptors.create') }}" title="Agregar Preceptor" class="btn btn-outline-primary me-2">
                <i class="fas fa-user-tie"></i> Nuevo Preceptor
            </a>
            <a href="{{ route('cursos.show', $curso->id) }}" title="Volver" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container text-center">
        <div class="card p-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cursos.guardar_preceptor', $curso->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="id_preceptor">Seleccionar Preceptor:</label>
                    <select name="id_preceptor" id="id_preceptor" class="form-control" required>
                        <option value="">-- Seleccione --</option>
                        @foreach ($preceptores as $preceptor)
                            <option value="{{ $preceptor->id }}"
                                {{ $curso->id_preceptor == $preceptor->id ? 'selected' : '' }}>
                                {{ $preceptor->apellido }}, {{ $preceptor->nombre }} (DNI: {{ $preceptor->dni }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Asignar</button>
                    <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
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
