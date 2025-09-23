@extends('adminlte::page')

@section('title', 'Vincular Persona')

@section('content_header')
    <h4>Vincular Persona al Usuario: {{ $user->name }}</h4>
@endsection

@section('content')
    <form action="{{ route('users.guardarVinculacion', $user->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="tipo">Tipo de Persona:</label>
            <select name="tipo" id="tipo" class="form-control" required>
                <option value="">-- Seleccionar --</option>
                <option value="preceptor">Preceptor</option>
                <option value="docente">Docente</option>
                <option value="administrativo">Administrativo</option>
            </select>
        </div>

        <div class="form-group mt-3" id="persona-container" style="display: none;">
            <label for="persona_id">Seleccionar Persona:</label>
            <select name="persona_id" id="persona_id" class="form-control select2">
                <!-- Se llena con JS dinámicamente -->
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Vincular</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        const preceptores = @json($preceptores);
        const docentes = @json($docentes);

        $('#tipo').on('change', function () {
            const tipo = $(this).val();
            const $select = $('#persona_id');
            let opciones = [];

            if (tipo === 'preceptor') {
                opciones = preceptores.map(p => ({ id: p.id, text: `${p.apellido}, ${p.nombre}` }));
            } else if (tipo === 'docente') {
                opciones = docentes.map(d => ({ id: d.id, text: `${d.apellido}, ${d.nombre}` }));
            }

            $select.empty().select2({
                data: opciones,
                width: '100%'
            });

            $('#persona-container').show();
        });

        $(document).ready(function () {
            $('.select2').select2({ width: '100%' });
        });
    </script>
@endsection
