@extends('adminlte::page')

@section('title', 'Registrar Alumno')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Registrar Nuevo Alumno</strong></span>
        </h4>
        <div class="d-flex">
            <button type="submit" form="alumnosForm" class="btn btn-outline-success me-2">
                <i class="fas fa-save"></i> Guardar
                <span class="badge bg-light text-success border border-success ms-2">Ctrl + G</span>
            </button>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }} <a href="{{ route('home') }}">Ver Cursos</a>
            </div>
        @endif
        <div class="card p-4">
            <form action="{{ route('alumnos.store') }}" id="alumnosForm" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <h5>Datos Personales</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="nombre">Nombre</label>
                                    <input type="text" name="nombre" maxlength="100" minlength="2" id="nombre" class="form-control"  required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="apellido">Apellido</label>
                                    <input type="text" name="apellido" maxlength="100" minlength="2" id="apellido" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="dni">DNI</label>
                                    <input type="text" maxlength="10" minlength="2" name="dni" id="dni" class="form-control" required>
                                    <!-- Aquí se mostrará el mensaje si está repetido -->
                                    <div id="dniMessage" style="margin-top: 0.5rem;"></div>
                                    @error('dni')
                                        <div class="text-danger" style="margin-top: 0.5rem;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <script>
                                    let timer;
                                    const dniInput = document.getElementById('dni');
                                    const messageDiv = document.getElementById('dniMessage');

                                    dniInput.addEventListener('input', function() {
                                        // Limpiamos cualquier timer previo para que no llame demasiadas veces
                                        clearTimeout(timer);

                                        // Disparamos la verificación 0.5s después de que el usuario deja de tipear
                                        timer = setTimeout(checkDni, 500);
                                    });

                                    function checkDni() {
                                        const dniValue = dniInput.value.trim();
                                        if (dniValue !== '') {
                                            fetch(`{{ route('alumnos.check.dni') }}?dni=${dniValue}`)
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.exists) {
                                                        // Si ya existe el DNI, mostramos el link de edición
                                                        messageDiv.innerHTML = `El DNI <strong>${dniValue}</strong> ya está registrado. ` +
                                                            `<a href="${data.edit_url}">Ver registro / Editar</a>`;
                                                    } else {
                                                        // Si no existe, limpiamos el mensaje
                                                        messageDiv.innerHTML = '';
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Error:', error);
                                                });
                                        } else {
                                            // Si está vacío, no mostramos nada
                                            messageDiv.innerHTML = '';
                                        }
                                    }
                                </script>

                                <div class="mb-3">
                                    <label class="form-label" for="cuil">CUIL</label>
                                    <input type="text" maxlength="15" minlength="2" name="cuil" id="cuil" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="fecha_nacimiento">Fecha de Nacimiento</label>
                                    <input type="date" min="01/01/1935" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" name="email" id="email" minlength="4" maxlength="150" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="celular">Celular</label>
                                    <input type="text" name="celular" id="celular" minlength="4" maxlength="20" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="telefono">Telefono/Otro Celular</label>
                                    <input type="text" name="telefono" id="telefono" minlength="4" maxlength="20" class="form-control">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <h5>Datos Familiares</h5>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="nombre_tutor">Nombre de Tutor</label>
                            <input type="text" name="nombre_tutor" maxlength="100" minlength="2" id="nombre_tutor" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="apellido_tutor">Apellido de Tutor</label>
                            <input type="text" name="apellido_tutor" id="apellido_tutor" maxlength="100" minlength="2" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="parentesco_tutor">Parentesco</label><br>
                            <select name="parentesco_tutor" id="parentesco_tutor" class="form-control" required>
                                <option value="">Seleccione parentesco</option>
                                <option value="Padre">Padre</option>
                                <option value="Madre">Madre</option>
                                <option value="Abuela Paterna">Abuela Paterna</option>
                                <option value="Abuelo Paterno">Abuelo Paterno</option>
                                <option value="Abuela Materna">Abuela Materna</option>
                                <option value="Abuelo Materno">Abuelo Materno</option>
                                <option value="Tío/a">Tío/a</option>
                                <option value="Hermano/a">Hermano/a</option>
                                <option value="Primo/a">Primo/a</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="dni_tutor">DNI Tutor</label>
                            <input type="text" name="dni_tutor" maxlength="10" minlength="2" id="dni_tutor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="cuil_tutor">CUIL Tutor</label>
                            <input type="text" name="cuil_tutor" maxlength="15" minlength="2" id="cuil_tutor" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="celular_tutor">Celular Tutor</label>
                            <input type="text" name="celular_tutor" maxlength="15" id="celular_tutor" class="form-control">
                        </div>
                        <h5>Domicilio</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="form-label" for="direccion">Dirección/Calle</label>
                                <input type="text" name="direccion" maxlength="255" id="direccion" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="numero">Nro</label>
                                <input type="text" maxlength="10" name="numero" id="numero" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" for="barrio">Barrio</label><br>
                                <select name="barrio" id="barrio" class="form-control">
                                    <option value="">Seleccione barrio</option>
                                    @foreach ($barrios as $barrio)
                                        <option value="{{$barrio->barrio}}">{{$barrio->barrio}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="localidad">Localidad</label><br>
                                <select name="localidad" id="localidad" class="form-control">
                                    <option value="">Seleccione barrio</option>
                                    @foreach ($localidades as $localidad)
                                        <option value="{{$localidad->localidad}}">{{$localidad->localidad}}</option>
                                    @endforeach
                                </select>
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
                            <input type="text" name="primaria" maxlength="255" id="primaria" class="form-control">
                        </div>
                        <label class="form-label mb-0">Otros Datos</label>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="cud">CUD</label>
                            <select name="cud" id="cud" class="form-control">
                                <option value="">Seleccione opción</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="observacion">Observaciones</label>
                            <textarea class="form-control" maxlength="500" name="observacion" id="observacion" cols="30" rows="8"></textarea>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <h5>Datos Administrativos</h5>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="fecha_inscripcion">Fecha de Inscripción</label>
                            <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" class="form-control">
                        </div>
                        <label class="form-label mb-0">Documentación presentada</label>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="inscripcion_web">Inscripción Web</label>
                                    <select name="inscripcion_web" id="inscripcion_web" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="constancia_septimo">Constancia de 7mo Grado</label>
                                    <select name="constancia_septimo" id="constancia_septimo" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="ficha_salud">Ficha de Salud</label>
                                    <select name="ficha_salud" id="ficha_salud" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="fotocopia_dni_tutor">Fotocopia de DNI del Tutor</label>
                                    <select name="fotocopia_dni_tutor" id="fotocopia_dni_tutor" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="evaluacion">Aprobó Examen de Ingreso</label>
                                    <select name="evaluacion" id="evaluacion" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="partida_nacimiento">Partida de Nacimiento</label>
                                    <select name="partida_nacimiento" id="partida_nacimiento" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="fotocopia_dni">Fotocopia de DNI</label>
                                    <select name="fotocopia_dni" id="fotocopia_dni" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="abanderado">Documentación de Abanderado</label>
                                    <select name="abanderado" id="abanderado" class="form-control">
                                        <option value="">Seleccione opción</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="hermanos">Tiene hermanos en la EPA</label>
                            <select name="hermanos" id="hermanos" class="form-control">
                                <option value="">Seleccione opción</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                @php
                    $userId = auth()->id();
                @endphp
                <input type="text" name="create_user_id" id="create_user_id" value="{{ $userId }}" hidden>
                <div class="row mt-2 mb-4">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Guardar</button>
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
                    "{{ route('home') }}";
            }
        });
    </script>
@endsection
