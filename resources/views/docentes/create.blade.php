@extends('adminlte::page')

@section('title', 'Nuevo Docente | REGLA')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Nuevo Docente</strong></span>
        </h4>
        <div class="d-flex">
            <a href="{{ route('docentes.index') }}" title="Lista de Docentes" class="btn btn-outline-primary me-2">
                <i class="fas fa-list"></i> Lista de Docentes
            </a>
            <a href="{{ route('home') }}" title="Volver" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
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

            <form action="{{ route('docentes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <h5>Datos Personales</h5>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Apellido:</label>
                            <input minlength="2" maxlength="100" type="text" class="form-control"
                                name="apellido" value="{{ old('apellido') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre:</label>
                            <input minlength="2" maxlength="100" type="text" class="form-control"
                                name="nombre" value="{{ old('nombre') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">DNI:</label>
                            <input maxlength="10" type="text" class="form-control" name="dni"
                                value="{{ old('dni') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CUIL:</label>
                            <input maxlength="15" type="text" class="form-control" name="cuil"
                                value="{{ old('cuil') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha de nacimiento:</label>
                            <input type="date" class="form-control" name="fecha_nacimiento"
                                value="{{ old('fecha_nacimiento') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5>Contacto</h5>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input maxlength="150" type="email" class="form-control" name="email"
                                value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono:</label>
                            <input maxlength="20" type="text" class="form-control" name="telefono"
                                value="{{ old('telefono') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Celular:</label>
                            <input maxlength="20" type="text" class="form-control" name="celular"
                                value="{{ old('celular') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h5>Datos Profesionales</h5>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Título:</label>
                            <input maxlength="100" type="text" class="form-control" name="titulo"
                                value="{{ old('titulo') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Segundo Título:</label>
                            <input maxlength="255" type="text" class="form-control" name="segundo_titulo"
                                value="{{ old('segundo_titulo') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha Ingreso a la docencia:</label>
                            <input type="date" class="form-control" name="fecha_ingreso"
                                value="{{ old('fecha_ingreso') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha Ingreso EPA:</label>
                            <input type="date" class="form-control" name="fecha_ingreso_epa"
                                value="{{ old('fecha_ingreso_epa') }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Declaración Jurada:</label>
                                <input type="checkbox" class="form-control" name="declaracion_jurada"
                                    value="1" {{ old('declaracion_jurada') ? 'checked' : '' }}>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Legajo:</label>
                                <input maxlength="10" type="text" class="form-control" name="legajo"
                                    value="{{ old('legajo') }}">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="form-label">Horas EPA:</label>
                                <input type="number" class="form-control" name="horas_epa"
                                    value="{{ old('horas_epa') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Horas Totales:</label>
                                <input type="number" class="form-control" name="horas_totales"
                                    value="{{ old('horas_totales') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5>Dirección</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="form-label">Dirección/Calle:</label>
                                <input type="text" class="form-control" name="direccion"
                                    value="{{ old('direccion') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Número:</label>
                                <input type="text" class="form-control" name="numero"
                                    value="{{ old('numero') }}">
                            </div>
                        </div>
                        <div class="mb-3 mt-2">
                            <label class="form-label" for="barrio">Barrio</label>
                            <select name="barrio" id="barrio" class="form-control">
                                <option value="">Seleccione barrio</option>
                                @foreach ($barrios as $barrio)
                                    <option value="{{ $barrio->barrio }}" {{ old('barrio') == $barrio->barrio ? 'selected' : '' }}>
                                        {{ $barrio->barrio }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="localidad">Localidad</label>
                            <select name="localidad" id="localidad" class="form-control">
                                <option value="">Seleccione localidad</option>
                                @foreach ($localidades as $localidad)
                                    <option value="{{ $localidad->localidad }}" {{ old('localidad') == $localidad->localidad ? 'selected' : '' }}>
                                        {{ $localidad->localidad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Observaciones:</label>
                            <textarea name="observaciones" class="form-control">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('docentes.index') }}" class="btn btn-secondary">Volver al listado</a>
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
        console.log('Formulario de creación de docentes cargado');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
