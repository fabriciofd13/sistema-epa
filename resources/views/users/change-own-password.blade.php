@extends('adminlte::page')

@section('title', 'Cambiar Contraseña | REGLA')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Cambiar Contraseña</strong></span>
        </h4>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            <i class="fas fa-times"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card p-4">
            @if (session('success'))
                <div style="color: green;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li> {{ $error }} </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.changeOwnPassword') }}" method="POST">
                @csrf

                <div>
                    <label class="form-label">Contraseña actual:</label>
                    <input class="form-control" minlength="6" maxlength="255" type="password" name="current_password" required />
                    
                </div>

                <div>
                    <label class="form-label">Nueva contraseña:</label>
                    <input class="form-control" minlength="6" maxlength="255" type="password" name="new_password" required />
                    <p>* Longitud Minima 6 caracteres</p>
                </div>

                <div>
                    <label class="form-label">Confirmar nueva contraseña:</label>
                    <input class="form-control" minlength="6" maxlength="255" type="password" name="new_password_confirmation" required />                    
                </div>

                <button class="btn btn-primary mt-3" type="submit">Cambiar Contraseña</button>
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
