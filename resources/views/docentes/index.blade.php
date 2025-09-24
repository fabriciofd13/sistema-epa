@extends('adminlte::page')

@section('title', 'Docentes | REGLA')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Docentes</strong></span>
        </h4>
        <div class="d-flex">
            <a href="{{ route('docentes.create') }}" title="Agregar Docente" class="btn btn-outline-primary me-2">
                <i class="fas fa-chalkboard-teacher"></i> Nuevo Docente
            </a>
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
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Apellido</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>CUIL</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($docentes) > 0)
                            @foreach ($docentes as $docente)
                                <tr>
                                    <td>{{ $docente->apellido }}</td>
                                    <td>{{ $docente->nombre }}</td>
                                    <td>{{ $docente->dni }}</td>
                                    <td>{{ $docente->cuil }}</td>
                                    <td>{{ $docente->telefono }}</td>
                                    <td>
                                        <a href="{{ route('docentes.edit', $docente->id) }}"
                                            class="btn btn-primary btn-sm">Editar</a>
                                        <form id="form-delete-{{ $docente->id }}"
                                            action="{{ route('docentes.destroy', $docente->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $docente->id }})">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <p>Aún no hay docentes agregados, <a href="{{ route('docentes.create') }}">¿desea
                                            agregar uno?</a></p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{ $docentes->links() }}
        </div>
        @include('partials.footer')
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + id).submit();
                }
            })
        }
    </script>

    <script>
        console.log('Página de docentes cargada');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
