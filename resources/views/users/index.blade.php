@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Lista de Usuarios</strong></span>
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
            <div class="row mt-2">
                <div class="col-md-3">
                    <a class="btn btn-primary" href="{{ route('users.create') }}">Crear nuevo usuario</a>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->rol }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Editar</a> |
                                        <a class="btn btn-warning"
                                            href="{{ route('users.changeUserPasswordForm', $user->id) }}">Cambiar
                                            Contraseña</a>

                                        {{-- Botón para eliminar --}}
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit"
                                                onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No hay usuarios registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
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
