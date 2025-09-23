@extends('adminlte::page')

@section('title', 'Página en Construcción')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Nuevo Preceptor</strong></span>
        </h4>
        <div class="d-flex">
            <a href="{{ route('preceptors.index') }}" title="Lista de Preceptores" class="btn btn-outline-primary me-2">
                <i class="fas fa-list"></i> Lista de Preceptores
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


            <form action="{{ route('preceptors.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <h5>Datos Personales</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Apellido:</label>
                                    <input minlength="2" maxlength="100" type="text" class="form-control"
                                        name="apellido" value="{{ old('apellido') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nombre:</label>
                                    <input minlength="2" maxlength="100" type="text" class="form-control" name="nombre"
                                        value="{{ old('nombre') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">DNI:</label><br>
                                    <input minlength="2" maxlength="10" type="text" class="form-control" name="dni"
                                        value="{{ old('dni') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CUIL:</label><br>
                                    <input minlength="2" maxlength="15" type="text" class="form-control" name="cuil"
                                        value="{{ old('cuil') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Fecha de nacimiento:</label><br>
                                    <input type="date" class="form-control" name="fecha_nacimiento"
                                        value="{{ old('fecha_nacimiento') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Contacto</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Email:</label><br>
                                    <input maxlength="150" type="email" class="form-control" name="email"
                                        value="{{ old('email') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Teléfono:</label><br>
                                    <input maxlength="20" type="text" class="form-control" name="telefono"
                                        value="{{ old('telefono') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Celular:</label><br>
                                    <input maxlength="20" type="text" class="form-control" name="celular"
                                        value="{{ old('celular') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Datos Profesionales</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Título:</label>
                                    <input maxlength="100" type="text" class="form-control" name="titulo"
                                        value="{{ old('titulo') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Segundo Título:</label><br>
                                    <input maxlength="255" type="text" class="form-control" name="segundo_titulo"
                                        value="{{ old('segundo_titulo') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Fecha Ingreso a la docencia:</label><br>
                                    <input type="date" class="form-control" name="fecha_ingreso"
                                        value="{{ old('fecha_ingreso') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Fecha Ingreso EPA:</label><br>
                                    <input type="date" class="form-control" name="fecha_ingreso_epa"
                                        value="{{ old('fecha_ingreso_epa') }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Declaración Jurada:</label><br>
                                            <input type="checkbox" class="form-control" name="declaracion_jurada"
                                                value="1" {{ old('declaracion_jurada') ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Legajo:</label><br>
                                            <input maxlength="6" type="text" class="form-control" name="legajo"
                                                value="{{ old('legajo') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Horas EPA:</label><br>
                                            <input min="0" max="36" minlength="1" maxlength="3"
                                                type="number" class="form-control" name="horas_epa"
                                                value="{{ old('horas_epa') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Horas Totales:</label><br>
                                            <input min="0" max="72" minlength="1" maxlength="3"
                                                type="number" class="form-control" name="horas_totales"
                                                value="{{ old('horas_totales') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5>Dirección</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label">Dirección/Calle:</label>
                                            <input type="text" class="form-control" name="direccion"
                                                value="{{ old('direccion') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Número:</label>
                                            <input type="text" class="form-control" name="numero"
                                                value="{{ old('numero') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="barrio">Barrio</label><br>
                                    <select name="barrio" id="barrio" class="form-control">
                                        <option value="">Seleccione barrio</option>
                                        @foreach ($barrios as $barrio)
                                            <option value="{{ $barrio->barrio }}">{{ $barrio->barrio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="localidad">Localidad</label><br>
                                    <select name="localidad" id="localidad" class="form-control">
                                        <option value="">Seleccione barrio</option>
                                        @foreach ($localidades as $localidad)
                                            <option value="{{ $localidad->localidad }}">{{ $localidad->localidad }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label">Observaciones:</label><br>
                                        <textarea name="observaciones" class="form-control">{{ old('observaciones') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary mt-2">Guardar</button>
                        <a href="{{ route('preceptors.index') }}" class="btn btn-secondary mt-2">Volver al listado</a>
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
        console.log('Página en construcción cargada');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
