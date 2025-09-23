@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-ligth border border-secondary"><strong>Editar Rol</strong></span>
            <span class="badge bg-light border border-primary"><strong>{{ $user->name }}</strong></span>
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

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label class="form-label">Nombre:</label>
                    <input minlength="6" maxlength="255" class="form-control" type="text" name="name"
                        value="{{ old('name', $user->name) }}" required />
                </div>

                <div>
                    <label class="form-label">Email:</label>
                    <input minlength="4" maxlength="255" class="form-control" type="email" name="email"
                        value="{{ old('email', $user->email) }}" required />
                </div>

                <div>
                    <label class="form-label">Rol:</label>
                    <select class="form-control" name="rol" required>
                        <option value="">-- Seleccione Rol --</option>
                        <option value="Admin" {{ $user->rol === 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Docente" {{ $user->rol === 'Docente' ? 'selected' : '' }}>Docente</option>
                        <option value="Docente Integrador" {{ $user->rol === 'Docente Integrador' ? 'selected' : '' }}>
                            Docente Integrador</option>
                        <option value="Padre" {{ $user->rol === 'Padre' ? 'selected' : '' }}>Padre</option>
                        <option value="Alumno" {{ $user->rol === 'Alumno' ? 'selected' : '' }}>Alumno</option>
                        <option value="Administrativo" {{ $user->rol === 'Administrativo' ? 'selected' : '' }}>
                            Administrativo</option>
                        <option value="Preceptor" {{ $user->rol === 'Preceptor' ? 'selected' : '' }}>Preceptor</option>
                        <option value="Equipo Directivo" {{ $user->rol === 'Equipo Directivo' ? 'selected' : '' }}>Equipo
                            Directivo</option>
                        <option value="Asesor Pedagógico" {{ $user->rol === 'Asesor Pedagógico' ? 'selected' : '' }}>Asesor
                            Pedagógico</option>
                    </select>
                </div>

                {{-- 
            Si quisieras permitir cambiar la contraseña aquí directamente,
            podrías incluir un input "password" y validarlo en el update.
            Pero normalmente se maneja en otra vista o método.
        --}}

                <button class="btn btn-primary mt-3" type="submit">Actualizar</button>
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
