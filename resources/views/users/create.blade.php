@extends('adminlte::page')

@section('title', 'Nuevo Usuario')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Nuevo Usuario</strong></span>
        </h4>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card p-4">
            @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li> {{ $error }} </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div>
                    <label class="form-label">Nombre:</label>
                    <input class="form-control" minlength="6" maxlength="255" type="text" name="name" value="{{ old('name') }}" required />
                </div>

                <div>
                    <label class="form-label">Email:</label>
                    <input class="form-control" minlength="4" maxlength="255" type="email" name="email" value="{{ old('email') }}" required />
                </div>

                <div>
                    <label class="form-label">Contraseña:</label>
                    <input class="form-control" minlength="6" maxlength="255" type="password" name="password" required />
                </div>

                <div>
                    <label class="form-label">Rol:</label>
                    <select name="rol" class="form-control" required>
                        <option value="">-- Seleccione Rol --</option>
                        <option value="Admin">Admin</option>
                        <option value="Docente">Docente</option>
                        <option value="Docente Integrador">Docente Integrador</option>
                        <option value="Padre">Padre</option>
                        <option value="Alumno">Alumno</option>
                        <option value="Administrativo">Administrativo</option>
                        <option value="Preceptor">Preceptor</option>
                        <option value="Equipo Directivo">Equipo Directivo</option>
                        <option value="Asesor Pedagógico">Asesor Pedagógico</option>
                    </select>
                </div>

                <button class="btn btn-secondary mt-3" type="submit">Guardar</button>
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
        console.log('Página de inicio cargada correctamente');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
