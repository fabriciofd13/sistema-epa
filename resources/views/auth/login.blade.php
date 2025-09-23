{{-- @extends('adminlte::auth.login') --}}
{{-- @extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif

@section('auth_header', 'Bienvenido, ingrese sus datos')

@section('auth_body')
    <form action="{{ $login_url }}" method="post">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="{{ __('adminlte::adminlte.password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="row">


            <div class="col-12">
                <button type=submit class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                    <span class="fas fa-sign-in-alt"></span>
                    Iniciar Sesión
                </button>
            </div>
        </div>

    </form>
@stop

@section('auth_footer')
    @if ($password_reset_url)
        <p class="my-0 text-center" style="font-size: 10px">

            <a href="{{ route('info') }}">
            <img src="{{ asset('img/regla_logo.png') }}" alt="Logo REGLA" width="18px" height="18px">
             Registro Electrónico de Gestión y Lógistica Académica &copy; {{ date('Y') }}
            </a>
        </p>
    @endif

    @if ($register_url)
        <p class="my-0">
        </p>
    @endif
@stop --}}
{{-- @extends('layouts.login-base')

@section('custom_css')
    <style>
        .login-wrapper {
            display: flex;
            min-height: 100vh;
            flex-direction: row;
        }

        .login-left {
            position: relative;
            flex: 1;

            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            flex-direction: column;
            text-align: center;
            overflow: hidden;
        }

        .login-left::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('img/background2.png') }}') no-repeat center center;
            background-size: cover;
            opacity: 0.2;
            z-index: 0;
        }

        .login-left * {
            position: relative;
            z-index: 1;
        }

        .login-right {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background: linear-gradient(to bottom, #fefaf6, #fdf6ec);
        }


        .login-right::before {
            content: "";
            position: absolute;
            left: -40px;
            top: 0;
            width: 40px;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 40 1000' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M40,0 C20,100 20,200 40,300 C20,400 20,500 40,600 C20,700 20,800 40,900 C20,1000 20,1100 40,1200 L0,1200 L0,0 Z' fill='%23fdf6ec'/%3E%3C/svg%3E") no-repeat center center;
            background-size: cover;
            z-index: 2;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 3;
        }

        .login-footer {
            margin-top: auto;
            padding: 1rem;
            font-size: 0.85rem;
            color: #888;
            text-align: center;
            z-index: 3;
        }

        #typing-title {
            color: #003366;
            font-size: 300%;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        #typing-subtitle {
            color: #003366;
            font-size: 100%;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-left,
            .login-right {
                width: 100%;
            }

            .login-right::before {
                display: none;
            }

            #typing-title {
                font-size: 180%;
            }

            #typing-subtitle {
                font-size: 140%;
            }
        }
    </style>
@endsection


@section('content')
    <div class="login-wrapper">
        <div class="login-left">
            <h1 id="typing-title">R.E.G.L.A</h1>
            <p id="typing-subtitle">Bienvenido al Registro Electrónico de<br>
                Gestión y Logistica Académica</p>
        </div>

        <div class="login-right">
            <div class="login-box">
                <div class="login-logo">
                    <a href="home">
                        <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="EPA Logo" height="50">
                        <b>EPA1</b> Medardo Pantoja
                    </a>
                </div>
                <h4 class="mb-4 text-center">Iniciar sesión</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Ups!</strong> Hubo problemas con tus datos.<br><br>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email">Correo electrónico</label>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}"
                            required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                </form>
            </div>

            <div class="login-footer mt-4">
                <a href="#" data-toggle="modal" data-target="#infoModal">¿Qué es REGLA?</a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Acerca de REGLA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    REGLA (Registro Electrónico de Gestión y Logística Académica) es un sistema diseñado para optimizar
                    la administración escolar, permitiendo a los docentes y preceptores registrar notas, asistencias,
                    novedades y gestionar la información académica de manera eficiente.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_js')
    <script>
        const titleText = 'R.E.G.L.A.';
        const subtitleText = 'Bienvenido al Registro Electrónico de\nGestión y Logística Académica';

        function typeText(elementId, text, delay = 50, callback = null) {
            const element = document.getElementById(elementId);
            element.innerHTML = ''; // Limpiar contenido previo
            let i = 0;

            function typeChar() {
                if (i < text.length) {
                    const char = text.charAt(i) === '\n' ? '<br>' : text.charAt(i);
                    element.innerHTML += char;
                    i++;
                    setTimeout(typeChar, delay);
                } else if (callback) {
                    callback();
                }
            }

            typeChar();
        }

        function startTypingAnimation() {
            typeText('typing-title', titleText, 100, () => {
                typeText('typing-subtitle', subtitleText, 30);
            });
        }

        // Ejecutar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            startTypingAnimation();
            setInterval(startTypingAnimation, 20000); // Repetir cada 30 segundos
        });
    </script>
@endsection
 --}}
@extends('layouts.login-base')
@section('custom_css')
    <style>
        body {
            background: url('{{ asset('img/background2.png') }}') no-repeat center center fixed;
            background-size: cover;
        }

        .login-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
            gap: 2rem;
            max-width: 1000px;
            /* nuevo: limita el ancho en pantallas grandes */
            margin: 0 auto;
            /* nuevo: centra horizontalmente */
        }

        .left-info {
            flex: 1;
            color: #003366;
            text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.6);
        }

        #typing-title {
            font-family: 'Arial Black', Gadget, sans-serif;
            font-size: 380%;
            font-weight: normal;
            color: #003366;
            margin-bottom: 1rem;
        }

        #typing-subtitle {
            font-size: 140%;
            line-height: 1.5;
        }

        .login-right {
            background: linear-gradient(to bottom, #fefaf6, white);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .login-box {
            width: 100%;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }

        .login-footer {
            font-size: 0.85rem;
            color: #555;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                align-items: center;
                padding: 1rem;
            }

            .left-info {
                text-align: center;
            }

            #typing-title {
                font-family: 'Arial Black', Gadget, sans-serif;
                font-size: 280%;
                font-weight: bolder;
                color: #003366;
                letter-spacing: 2px;
                margin-bottom: 1rem;
            }

            #typing-subtitle {
                font-size: 110%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="login-wrapper">
        {{-- Área izquierda con el texto institucional --}}
        <div class="left-info">
            <h1 id="typing-title">R.E.G.L.A.</h1>
            <p id="typing-subtitle">
                Bienvenido al Registro Electrónico<br>
                de Gestión y Logística Académica
            </p>
        </div>

        {{-- Caja de login a la derecha --}}
        <div class="login-right">
            <div class="login-box">
                <div class="login-logo text-center">
                    <a href="home">
                        <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="EPA Logo" height="50">
                        <br><b>EPA1</b> Medardo Pantoja
                    </a>
                </div>

                <h4 class="mb-4 text-center">Iniciar sesión</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Ups!</strong> Hubo problemas con tus datos.<br><br>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email">Correo electrónico</label>
                        <input id="email" maxlength="255" minlength="4" type="email" name="email"
                            class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password">Contraseña</label>
                        <input id="password" maxlength="255" minlength="4" type="password" name="password"
                            class="form-control" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                </form>

                <div class="login-footer mt-4 text-center">
                    <a href="#" data-toggle="modal" data-target="#infoModal">¿Qué es REGLA?</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Acerca de REGLA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                        <img src="{{ asset('img/regla_logo.png') }}" alt="Logo REGLA" width="30" height="30">
                    <p class="text-justify pl-2 pr-2"><strong>R.E.G.L.A.</strong> (Registro Electrónico de Gestión y Logística
                        Académica) es un sistema
                        diseñado para optimizar
                        la administración escolar, permitiendo a los docentes y preceptores registrar notas, asistencias,
                        novedades y gestionar la información académica de manera eficiente.</p>
                    </p>
                    <p><strong>Versión:</strong> 1.0.0<br>
                        <strong>Desarrollado por:</strong> Fabricio Fernández<br>
                        <strong>Contacto de Soporte:</strong> fabridfernandez@gmail.com
                    </p>
                    <hr>
                    <p><strong>Institución:</strong> Escuela Provincial de Artes N° 1 "Medardo Pantoja"</p>
                    <p><strong>Contacto de la Institución:</strong> escueladeartes1jujuy@gmail.com</p>
                    <p><strong>Sitio Web:</strong> <a href="https://www.escueladeartes1.edu.ar"
                            target="_blank">www.escueladeartes1.edu.ar</a></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom_js')
    <script>
        const titleText = 'R.E.G.L.A.';
        const subtitleText = 'Bienvenido al Registro Electrónico de\nGestión y Logística Académica';

        let isTyping = false; //  Evita superposiciones

        function typeText(elementId, text, delay = 50, callback = null) {
            const element = document.getElementById(elementId);
            element.innerHTML = ''; // Limpiar contenido previo
            let i = 0;

            function typeChar() {
                if (i < text.length) {
                    const char = text.charAt(i) === '\n' ? '<br>' : text.charAt(i);
                    element.innerHTML += char;
                    i++;
                    setTimeout(typeChar, delay);
                } else if (callback) {
                    callback();
                } else {
                    isTyping = false; //  Marcamos que terminó
                }
            }

            typeChar();
        }

        function startTypingAnimation() {
            if (isTyping) return; //  Si ya está escribiendo, no hacer nada
            isTyping = true;

            typeText('typing-title', titleText, 100, () => {
                typeText('typing-subtitle', subtitleText, 30);
            });
        }

        // Ejecutar al cargar y luego cada 20 segundos
        document.addEventListener('DOMContentLoaded', function() {
            startTypingAnimation();
            setInterval(startTypingAnimation, 20000);
        });
    </script>
@endsection
