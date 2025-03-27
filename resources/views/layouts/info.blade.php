<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Información</title>

    <!-- Tu hoja de estilos personalizada (si aplica) -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <script>
        console.log('Página de inicio cargada correctamente');
    </script>
</head>

<body style="background-color: #e9ecef">

    <div style="text-align: center;">
        <div class="modal-header">
            <h3>Información del Sistema</h3>

        </div>
        <div class="modal-body">
            <p class="text-center">
                <img src="{{ asset('img/regla_logo.png') }}" alt="Logo REGLA" width="50" height="50">
                <br><strong>Registro Electrónico de Gestión y Lógistica Académica</strong><br>
            </p>
            <p><strong>Versión:</strong> 1.0.0<br>
                <strong>Desarrollado por:</strong> Fabricio Fernández<br>
                <strong>Contacto de Soporte:</strong> fabridfernandez@gmail.com
            </p>
            <hr>
            <p><strong>Institución:</strong> Escuela Provincial de Artes N° 1 "Medardo Pantoja"</p>
            <p><strong>Contacto de la Institución:</strong> escueladeartes1jujuy@gmail.com</p>
            <p><strong>Descripción:</strong> Sistema escolar para la gestión de alumnos, docentes y cursos.</p>
        </div>

        <a href="home" class="modal-header">
            Volver
        </a>

        <!-- Tu script personalizado (si aplica) -->
        <script src="{{ asset('js/custom.js') }}"></script>
    </div>
</body>

</html>
