@extends('adminlte::page')

@section('title', 'Página en Construcción')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Nuevo Preceptor</strong></span>
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

            <form action="{{ route('preceptors.update', $preceptor) }}" method="POST">
                @csrf
                @method('PUT')

                <label>Apellido:</label>
                <input type="text" name="apellido" value="{{ old('apellido', $preceptor->apellido) }}"><br><br>

                <label>Nombre:</label>
                <input type="text" name="nombre" value="{{ old('nombre', $preceptor->nombre) }}"><br><br>

                <label>DNI:</label>
                <input type="text" name="dni" value="{{ old('dni', $preceptor->dni) }}"><br><br>

                <label>CUIL:</label>
                <input type="text" name="cuil" value="{{ old('cuil', $preceptor->cuil) }}"><br><br>

                <label>Fecha de nacimiento:</label>
                <input type="date" name="fecha_nacimiento"
                    value="{{ old('fecha_nacimiento', $preceptor->fecha_nacimiento) }}"><br><br>

                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email', $preceptor->email) }}"><br><br>

                <label>Teléfono:</label>
                <input type="text" name="telefono" value="{{ old('telefono', $preceptor->telefono) }}"><br><br>

                <label>Celular:</label>
                <input type="text" name="celular" value="{{ old('celular', $preceptor->celular) }}"><br><br>

                <label>Título:</label>
                <input type="text" name="titulo" value="{{ old('titulo', $preceptor->titulo) }}"><br><br>

                <label>Segundo Título:</label>
                <input type="text" name="segundo_titulo"
                    value="{{ old('segundo_titulo', $preceptor->segundo_titulo) }}"><br><br>

                <label>Localidad:</label>
                <input type="text" name="localidad" value="{{ old('localidad', $preceptor->localidad) }}"><br><br>

                <label>Dirección:</label>
                <input type="text" name="direccion" value="{{ old('direccion', $preceptor->direccion) }}"><br><br>

                <label>Barrio:</label>
                <input type="text" name="barrio" value="{{ old('barrio', $preceptor->barrio) }}"><br><br>

                <label>Número:</label>
                <input type="text" name="numero" value="{{ old('numero', $preceptor->numero) }}"><br><br>

                <label>Observaciones:</label><br>
                <textarea name="observaciones">{{ old('observaciones', $preceptor->observaciones) }}</textarea><br><br>

                <label>Fecha Ingreso:</label>
                <input type="date" name="fecha_ingreso"
                    value="{{ old('fecha_ingreso', $preceptor->fecha_ingreso) }}"><br><br>

                <label>Fecha Ingreso EPA:</label>
                <input type="date" name="fecha_ingreso_epa"
                    value="{{ old('fecha_ingreso_epa', $preceptor->fecha_ingreso_epa) }}"><br><br>

                <label>Declaración Jurada:</label>
                <input type="checkbox" name="declaracion_jurada" value="1"
                    {{ old('declaracion_jurada', $preceptor->declaracion_jurada) ? 'checked' : '' }}>
                <br><br>

                <label>Legajo:</label>
                <input type="text" name="legajo" value="{{ old('legajo', $preceptor->legajo) }}"><br><br>

                <label>Horas EPA:</label>
                <input type="text" name="horas_epa" value="{{ old('horas_epa', $preceptor->horas_epa) }}"><br><br>

                <label>Horas Totales:</label>
                <input type="text" name="horas_totales"
                    value="{{ old('horas_totales', $preceptor->horas_totales) }}"><br><br>

                <button type="submit">Actualizar</button>
            </form>

            <a href="{{ route('preceptors.index') }}">Volver al listado</a>
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
