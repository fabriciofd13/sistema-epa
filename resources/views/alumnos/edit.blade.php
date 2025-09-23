@extends('adminlte::page')

@section('title', 'Editar Alumno')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            Editando datos del alumno
            <span class="badge bg-light border border-secondary">{{ $alumno->apellido }}, {{ $alumno->nombre }} </span>
        </h4>
        <div class="d-flex">
            <button type="submit" form="alumnosForm" title="Guardar Alumno [Ctrl + G]" class="btn btn-outline-primary me-2">
                <i class="fas fa-user-plus"></i> Guardar
                <span class="badge bg-light text-primary border border-primary ms-2">Ctrl + G</span>
            </button>
            <a href="{{ route('alumnos.index') }}" title="Volver [Ctrl + X]" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }} <a href="{{ route('alumnos.index') }}">Ver Lista de Alumnos</a>
            </div>
        @endif
        <div class="card p-4">
            {{-- IMPORTANTE: Ajusta "$alumno->id" de acuerdo a tu modelo/ruta --}}
            <form action="{{ route('alumnos.update', $alumno->id) }}" id="alumnosForm" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <h5>Datos Personales</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="nombre">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" maxlength="100"
                                        minlength="2" value="{{ old('nombre', $alumno->nombre) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="apellido">Apellido</label>
                                    <input type="text" name="apellido" id="apellido" class="form-control"
                                        maxlength="100" minlength="2" value="{{ old('apellido', $alumno->apellido) }}"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="dni">DNI</label>
                                    <input type="text" name="dni" id="dni" class="form-control" maxlength="10"
                                        minlength="2" value="{{ old('dni', $alumno->dni) }}" disabled>
                                    <p class="alert alert-warning mt-2">Para editar el DNI contacte con el administrador</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="cuil">CUIL</label>
                                    <input type="text" name="cuil" id="cuil" maxlength="15" minlength="2"
                                        class="form-control" value="{{ old('cuil', $alumno->cuil) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="fecha_nacimiento">Fecha de Nacimiento</label>
                                    <input type="date" min="01/01/1935" name="fecha_nacimiento" id="fecha_nacimiento"
                                        class="form-control"
                                        value="{{ old('fecha_nacimiento', $alumno->fecha_nacimiento) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" name="email" minlength="4" maxlength="150" id="email"
                                        class="form-control" value="{{ old('email', $alumno->email) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="celular">Celular</label>
                                    <input type="text" name="celular" minlength="4" maxlength="20" id="celular"
                                        class="form-control" value="{{ old('celular', $alumno->celular) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="telefono">Telefono/Otro Celular</label>
                                    <input type="text" name="telefono" minlength="4" maxlength="20" id="telefono"
                                        class="form-control" value="{{ old('telefono', $alumno->telefono) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5>Datos Familiares</h5>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="nombre_tutor">Nombre de Tutor</label>
                            <input maxlength="100" minlength="2" type="text" name="nombre_tutor" id="nombre_tutor"
                                class="form-control" value="{{ old('nombre_tutor', $alumno->nombre_tutor) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="apellido_tutor">Apellido de Tutor</label>
                            <input maxlength="100" minlength="2" type="text" name="apellido_tutor"
                                id="apellido_tutor" class="form-control"
                                value="{{ old('apellido_tutor', $alumno->apellido_tutor) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="parentesco_tutor">Parentesco</label>
                            <select name="parentesco_tutor" id="parentesco_tutor" class="form-control" required>
                                <option value="">Seleccione parentesco</option>
                                <option value="Padre"
                                    {{ old('parentesco_tutor', $alumno->parentesco_tutor) == 'Padre' ? 'selected' : '' }}>
                                    Padre</option>
                                <option value="Madre"
                                    {{ old('parentesco_tutor', $alumno->parentesco_tutor) == 'Madre' ? 'selected' : '' }}>
                                    Madre</option>
                                <option value="Abuela Paterna"
                                    {{ old('parentesco_tutor', $alumno->parentesco_tutor) == 'Abuela Paterna' ? 'selected' : '' }}>
                                    Abuela Paterna</option>
                                <option value="Abuelo Paterno"
                                    {{ old('parentesco_tutor', $alumno->parentesco_tutor) == 'Abuelo Paterno' ? 'selected' : '' }}>
                                    Abuelo Paterno</option>
                                <option value="Abuela Materna"
                                    {{ old('parentesco_tutor', $alumno->parentesco_tutor) == 'Abuela Materna' ? 'selected' : '' }}>
                                    Abuela Materna</option>
                                <option value="Abuelo Materno"
                                    {{ old('parentesco_tutor', $alumno->parentesco_tutor) == 'Abuelo Materno' ? 'selected' : '' }}>
                                    Abuelo Materno</option>
                                <option value="Tío/a"
                                    {{ old('parentesco_tutor', $alumno->parentesco_tutor) == 'Tío/a' ? 'selected' : '' }}>
                                    Tío/a</option>
                                <option value="Hermano/a"
                                    {{ old('parentesco_tutor', $alumno->parentesco_tutor) == 'Hermano/a' ? 'selected' : '' }}>
                                    Hermano/a</option>
                                <option value="Primo/a"
                                    {{ old('parentesco_tutor', $alumno->parentesco_tutor) == 'Primo/a' ? 'selected' : '' }}>
                                    Primo/a</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="dni_tutor">DNI Tutor</label>
                            <input maxlength="10" minlength="2" type="text" name="dni_tutor" id="dni_tutor"
                                class="form-control" value="{{ old('dni_tutor', $alumno->dni_tutor) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="cuil_tutor">CUIL Tutor</label>
                            <input maxlength="15" minlength="2" type="text" name="cuil_tutor" id="cuil_tutor"
                                class="form-control" value="{{ old('cuil_tutor', $alumno->cuil_tutor) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="celular_tutor">Celular Tutor</label>
                            <input type="text" maxlength="15" name="celular_tutor" id="celular_tutor"
                                class="form-control" value="{{ old('celular_tutor', $alumno->celular_tutor) }}">
                        </div>

                        <h5>Domicilio</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="form-label" for="direccion">Dirección/Calle</label>
                                <input type="text" maxlength="255" name="direccion" maxlength="255" id="direccion"
                                    class="form-control" value="{{ old('direccion', $alumno->direccion) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="numero">Nro</label>
                                <input maxlength="10" type="text" maxlength="10" name="numero" id="numero"
                                    class="form-control" value="{{ old('numero', $alumno->numero) }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label" for="barrio">Barrio</label><br>
                                @if ($alumno->barrio)
                                    <input type="text" name="barrio" id="barrio"
                                        value="{{ old('barrio', $alumno->barrio) }}" maxlength="100"
                                        class="form-control">
                                @else
                                    <select name="barrio" id="barrio" class="form-control">
                                        <option value="">Seleccione barrio</option>
                                        @foreach ($barrios as $barrioItem)
                                            <option value="{{ $barrioItem->barrio }}" @selected(old('barrio', $alumno->barrio) == $barrioItem->barrio)>
                                                {{ $barrioItem->barrio }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="localidad">Localidad</label><br>
                                @if ($alumno->localidad)
                                    <input type="text" name="localidad" id="localidad"
                                        value="{{ old('localidad', $alumno->localidad) }}" maxlength="255"
                                        class="form-control">
                                @else
                                    <select name="localidad" id="localidad" class="form-control">
                                        <option value="">Seleccione localidad</option>
                                        @foreach ($localidades as $localidadItem)
                                            <option value="{{ $localidadItem->localidad }}" @selected(old('localidad', $alumno->localidad) == $localidadItem->localidad)>
                                                {{ $localidadItem->localidad }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <h5>Datos Académicos</h5>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="primaria">Escuela Primaria</label>
                            <input maxlength="255" type="text" name="primaria" id="primaria" class="form-control"
                                value="{{ old('primaria', $alumno->primaria) }}">
                        </div>
                        <label class="form-label mb-0">Otros Datos</label>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="cud">CUD</label>
                            <select name="cud" id="cud" class="form-control">
                                <option value="">Seleccione opción</option>
                                <option value="1" {{ old('cud', $alumno->cud) == 1 ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ old('cud', $alumno->cud) == 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="observacion">Observaciones</label>
                            <textarea class="form-control" maxlength="500" name="observacion" id="observacion" cols="30" rows="8">{{ old('observacion', $alumno->observacion) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5>Datos Administrativos</h5>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="fecha_inscripcion">Fecha de Inscripción</label>
                            <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" class="form-control"
                                value="{{ old('fecha_inscripcion', $alumno->fecha_inscripcion) }}">
                        </div>
                        <label class="form-label mb-0">Documentación presentada</label>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="inscripcion_web">Inscripción Web</label>
                                    <select name="inscripcion_web" id="inscripcion_web" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1"
                                            {{ old('inscripcion_web', $alumno->inscripcion_web) == 1 ? 'selected' : '' }}>
                                            Sí</option>
                                        <option value="0"
                                            {{ old('inscripcion_web', $alumno->inscripcion_web) == 0 ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="constancia_septimo">Constancia de 7mo Grado</label>
                                    <select name="constancia_septimo" id="constancia_septimo" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1"
                                            {{ old('constancia_septimo', $alumno->constancia_septimo) == 1 ? 'selected' : '' }}>
                                            Sí</option>
                                        <option value="0"
                                            {{ old('constancia_septimo', $alumno->constancia_septimo) == 0 ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="ficha_salud">Ficha de Salud</label>
                                    <select name="ficha_salud" id="ficha_salud" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1"
                                            {{ old('ficha_salud', $alumno->ficha_salud) == 1 ? 'selected' : '' }}>Sí
                                        </option>
                                        <option value="0"
                                            {{ old('ficha_salud', $alumno->ficha_salud) == 0 ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="fotocopia_dni_tutor">Fotocopia de DNI del Tutor</label>
                                    <select name="fotocopia_dni_tutor" id="fotocopia_dni_tutor" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1"
                                            {{ old('fotocopia_dni_tutor', $alumno->fotocopia_dni_tutor) == 1 ? 'selected' : '' }}>
                                            Sí</option>
                                        <option value="0"
                                            {{ old('fotocopia_dni_tutor', $alumno->fotocopia_dni_tutor) == 0 ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="evaluacion">Aprobó Examen de Ingreso</label>
                                    <select name="evaluacion" id="evaluacion" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1"
                                            {{ old('evaluacion', $alumno->evaluacion) == 1 ? 'selected' : '' }}>Sí</option>
                                        <option value="0"
                                            {{ old('evaluacion', $alumno->evaluacion) == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="partida_nacimiento">Partida de Nacimiento</label>
                                    <select name="partida_nacimiento" id="partida_nacimiento" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1"
                                            {{ old('partida_nacimiento', $alumno->partida_nacimiento) == 1 ? 'selected' : '' }}>
                                            Sí</option>
                                        <option value="0"
                                            {{ old('partida_nacimiento', $alumno->partida_nacimiento) == 0 ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="fotocopia_dni">Fotocopia de DNI</label>
                                    <select name="fotocopia_dni" id="fotocopia_dni" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1"
                                            {{ old('fotocopia_dni', $alumno->fotocopia_dni) == 1 ? 'selected' : '' }}>Sí
                                        </option>
                                        <option value="0"
                                            {{ old('fotocopia_dni', $alumno->fotocopia_dni) == 0 ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="abanderado">Documentación de Abanderado</label>
                                    <select name="abanderado" id="abanderado" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1"
                                            {{ old('abanderado', $alumno->abanderado) == 1 ? 'selected' : '' }}>Sí</option>
                                        <option value="0"
                                            {{ old('abanderado', $alumno->abanderado) == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="hermanos">¿Tiene hermanos en la EPA?</label>
                            <select name="hermanos" id="hermanos" class="form-control">
                                <option value="">Seleccione opción</option>
                                <option value="1" {{ old('hermanos', $alumno->hermanos) == 1 ? 'selected' : '' }}>Sí
                                </option>
                                <option value="0" {{ old('hermanos', $alumno->hermanos) == 0 ? 'selected' : '' }}>No
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 mb-4">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Actualizar</button>
                        <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>

    </div>
    {{-- Incluir el footer parcial --}}
    @include('partials.footer')
@endsection
@section('js')
    <script>
        console.log('Página de Nuevo Alumno cargada correctamente.');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        document.addEventListener("keydown", function(e) {
            document.addEventListener("keydown", function(e) {
                // Detecta Ctrl + G (en Mac sería Command + G)
                if ((e.ctrlKey || e.metaKey) && (e.key === "g" || e.key === "G")) {
                    e.preventDefault();
                    const form = document.getElementById("alumnosForm");

                    // Si el navegador soporta requestSubmit(), usémoslo:
                    if (typeof form.requestSubmit === 'function') {
                        form.requestSubmit();
                    } else {
                        // Fallback (ver Opción B más abajo)
                        if (form.checkValidity()) {
                            form.submit();
                        } else {
                            form.reportValidity();
                        }
                    }
                }
            });
            if ((e.ctrlKey || e.metaKey) && (e.key === 'x' || e.key === 'X')) {
                // Evita la acción por defecto (abrir nueva ventana)
                e.preventDefault();

                window.location.href =
                    "{{ route('alumnos.index') }}";
            }
        });
    </script>
@endsection
