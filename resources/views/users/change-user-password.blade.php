@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Cambiar Contraseña</strong></span>
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

            @if (session('success'))
                <div style="color: green;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('users.changeUserPassword', $user->id) }}" method="POST">
                @csrf
                {{-- Si usas PUT/PATCH, puedes agregar @method('PUT') o 'PATCH' aquí,
            pero en el ejemplo anterior usamos POST. Ajusta según tu ruta. --}}

                <div>
                    <label class="form-label">Nueva Contraseña:</label>
                    <input class="form-control" type="password" name="password" required />
                </div>

                <div>
                    <label class="form-label">Confirmar Contraseña:</label>
                    <input class="form-control" type="password" name="password_confirmation" required />
                </div>

                <button class="btn btn-primary mt-3" type="submit">Actualizar Contraseña</button>
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
