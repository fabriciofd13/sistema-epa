<div class="footer-copyright text-center py-3 navbar-white"
    style="bottom: 0;position: relative;margin-top:auto; margin-left:0px;padding:0;">
    &copy; {{ date('Y') }} - Sistema Escolar EPA - <a href="https://www.escueladeartes1.edu.ar"
        target="_blank">www.escueladeartes1.edu.ar</a>
    <span class="ms-3">
        <a href="#" id="versionInfo">
            - <b>Versión</b> 1.0.0
        </a>
    </span>
</div>

<!-- Modal de Información -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Información del Sistema</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p style="text-align: center;">
                    <img src="{{ asset('img/regla_logo.png') }}" alt="Logo REGLA" width="50px" height="50px">
                    <br><strong>Registro Electrónico de Gestión y Lógistica Académica</strong><br>
                </p>
                <p><strong>Versión:</strong> 1.0.0<br>
                    <strong>Desarrollado por</strong> Fabricio Fernández<br>
                    <strong>Contacto de Soporte:</strong> fabridfernandez@gmail.com
                </p>
                <hr>
                <p><strong>Institución:</strong> Escuela Provincial de Artes N° 1 "Medardo Pantoja"</p>
                <p><strong>Contacto de la Institución: </strong>escueladeartes1jujuy@gmail.com</p>
                <p><strong>Descripción:</strong> Sistema escolar para la gestión de alumnos, docentes y cursos.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
