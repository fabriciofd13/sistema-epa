@extends('adminlte::page')

@section('title', 'Editar Docente')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Editar Docente</strong></span>
        </h4>
        <div class="d-flex">
            <a href="{{ route('docentes.index') }}" title="Volver" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card p-4">
            @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('docentes.update', $docente->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <h5>Datos Personales</h5>
                        <hr>
                        @include('docentes.partials.form-fields', ['docente' => $docente])
                    </div>

                    <div class="col-md-6">
                        <h5>Dirección</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Dirección/Calle:</label>
                                    <input type="text" class="form-control" name="direccion"
                                        value="{{ old('direccion', $docente->direccion) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Número:</label>
                                    <input type="text" class="form-control" name="numero"
                                        value="{{ old('numero', $docente->numero) }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Barrio</label>
                            <select name="barrio" class="form-control">
                                <option value="">Seleccione barrio</option>
                                @foreach ($barrios as $barrio)
                                    <option value="{{ $barrio->barrio }}" {{ old('barrio', $docente->barrio) == $barrio->barrio ? 'selected' : '' }}>
                                        {{ $barrio->barrio }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Localidad</label>
                            <select name="localidad" class="form-control">
                                <option value="">Seleccione localidad</option>
                                @foreach ($localidades as $localidad)
                                    <option value="{{ $localidad->localidad }}" {{ old('localidad', $docente->localidad) == $localidad->localidad ? 'selected' : '' }}>
                                        {{ $localidad->localidad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Observaciones:</label>
                            <textarea name="observaciones" class="form-control">{{ old('observaciones', $docente->observaciones) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('docentes.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
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
        console.log('Página de edición de docente cargada');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
