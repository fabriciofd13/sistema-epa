@extends('adminlte::page')

@section('title', 'Preceptores')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Preceptores</strong></span>
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
            @if (session('success'))
                <div style="color: green;">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('preceptors.create') }}">Crear nuevo Preceptor</a>
            <div class="table-responsive">
                <table border="1" cellpadding="8" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Apellido</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>CUIL</th>
                            <th>Fecha Nacimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($preceptors as $preceptor)
                            <tr>
                                <td>{{ $preceptor->id }}</td>
                                <td>{{ $preceptor->apellido }}</td>
                                <td>{{ $preceptor->nombre }}</td>
                                <td>{{ $preceptor->dni }}</td>
                                <td>{{ $preceptor->cuil }}</td>
                                <td>{{ $preceptor->fecha_nacimiento }}</td>
                                <td>
                                    <a href="{{ route('preceptors.show', $preceptor) }}">Ver</a>
                                    <a href="{{ route('preceptors.edit', $preceptor) }}">Editar</a>
                                    <form action="{{ route('preceptors.destroy', $preceptor) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('¿Estás seguro de eliminar este preceptor?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No hay registros de preceptores.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $preceptors->links() }}
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
