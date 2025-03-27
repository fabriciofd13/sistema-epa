{{-- @extends('adminlte::page')

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

            <form action="{{ route('preceptors.store') }}" method="POST">
                @csrf
                <label>Apellido:</label>
                <input type="text" name="apellido" value="{{ old('apellido') }}"><br><br>

                <label>Nombre:</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}"><br><br>

                <label>DNI:</label>
                <input type="text" name="dni" value="{{ old('dni') }}"><br><br>

                <label>CUIL:</label>
                <input type="text" name="cuil" value="{{ old('cuil') }}"><br><br>

                <label>Fecha de nacimiento:</label>
                <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"><br><br>

                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email') }}"><br><br>

                <label>Teléfono:</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}"><br><br>

                <label>Celular:</label>
                <input type="text" name="celular" value="{{ old('celular') }}"><br><br>

                <label>Título:</label>
                <input type="text" name="titulo" value="{{ old('titulo') }}"><br><br>

                <label>Segundo Título:</label>
                <input type="text" name="segundo_titulo" value="{{ old('segundo_titulo') }}"><br><br>

                <label>Localidad:</label>
                <input type="text" name="localidad" value="{{ old('localidad') }}"><br><br>

                <label>Dirección:</label>
                <input type="text" name="direccion" value="{{ old('direccion') }}"><br><br>

                <label>Barrio:</label>
                <input type="text" name="barrio" value="{{ old('barrio') }}"><br><br>

                <label>Número:</label>
                <input type="text" name="numero" value="{{ old('numero') }}"><br><br>

                <label>Observaciones:</label><br>
                <textarea name="observaciones">{{ old('observaciones') }}</textarea><br><br>

                <label>Fecha Ingreso:</label>
                <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso') }}"><br><br>

                <label>Fecha Ingreso EPA:</label>
                <input type="date" name="fecha_ingreso_epa" value="{{ old('fecha_ingreso_epa') }}"><br><br>

                <label>Declaración Jurada:</label>
                <input type="checkbox" name="declaracion_jurada" value="1"
                    {{ old('declaracion_jurada') ? 'checked' : '' }}>
                <br><br>

                <label>Legajo:</label>
                <input type="text" name="legajo" value="{{ old('legajo') }}"><br><br>

                <label>Horas EPA:</label>
                <input type="text" name="horas_epa" value="{{ old('horas_epa') }}"><br><br>

                <label>Horas Totales:</label>
                <input type="text" name="horas_totales" value="{{ old('horas_totales') }}"><br><br>

                <button type="submit">Guardar</button>
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
 --}}
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

