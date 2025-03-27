<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CursoDivisionController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\HistorialAcademicoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PreceptorController;
use App\Http\Controllers\UserController;
use App\Models\CursoDivision;
use App\Models\Docente;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rutas de autenticación (Login, Register, etc.)
Auth::routes();

// Ruta principal del sistema (Página de inicio)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Rutas que solo el Admin puede acceder:

// CRUD de usuarios
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Editar rol de un usuario
Route::get('/users/{user}/edit-rol', [UserController::class, 'editRol'])->name('users.editRol');
Route::put('/users/{user}/update-rol', [UserController::class, 'updateRol'])->name('users.updateRol');

// Cambiar la contraseña de un usuario (por el Admin)
Route::get('/users/{user}/change-password', [UserController::class, 'changeUserPasswordForm'])->name('users.changeUserPasswordForm');
Route::post('/users/{user}/change-password', [UserController::class, 'changeUserPassword'])->name('users.changeUserPassword');


// Cualquier usuario puede cambiar su propia contraseña
Route::get('/profile/change-password', [UserController::class, 'changeOwnPasswordForm'])->name('users.changeOwnPasswordForm');
Route::post('/profile/change-password', [UserController::class, 'changeOwnPassword'])->name('users.changeOwnPassword');

// Rutas para el módulo de Alumnos
Route::get('/alumnos', [AlumnoController::class, 'index'])->name('alumnos.index'); // Ruta para mostrar la lista de alumnos
Route::get('/alumnos/create', [AlumnoController::class, 'create'])->name('alumnos.create'); // Mostrar formulario
Route::post('/alumnos', [AlumnoController::class, 'store'])->name('alumnos.store'); // Guardar alumno en la base de datos
Route::get('/alumnos/{id}/edit', [AlumnoController::class, 'edit'])->name('alumnos.edit'); // Ruta para mostrar el formulario de edición
Route::put('/alumnos/{id}', [AlumnoController::class, 'update'])->name('alumnos.update'); // Ruta para actualizar los datos del alumno
Route::get('/alumnos/{id}/notas', [AlumnoController::class, 'verNotas'])->name('alumnos.notas');
Route::get('/alumnos/{id}/notas-editar', [AlumnoController::class, 'verNotasEditables'])->name('alumnos.notas.editar');
Route::post('/alumnos/{id}/notas-guardar', [AlumnoController::class, 'guardarNotas'])->name('alumnos.notas.guardar');
Route::get('/alumnos/check-dni', [AlumnoController::class, 'checkDni'])->name('alumnos.check.dni'); // Ruta para verificar si existe un DNI repetido



//Rutas para el módulo de Cursos
Route::get('/cursos', [CursoDivisionController::class, 'index'])->name('cursos.index'); // Ruta para mostrar todos los cursos
Route::get('/cursos/{id}', [CursoDivisionController::class, 'show'])->name('cursos.show');
Route::get('/cursos/{id}/agregar-alumnos', [CursoDivisionController::class, 'getAlumnosSinCurso'])
    ->name('cursos.agregarAlumnos');
Route::post('/cursos/{id}/agregar-alumnos', [CursoDivisionController::class, 'agregarAlumnosCurso'])
    ->name('cursos.guardarAlumnos');

//Rutas para el módulo Notas
Route::get('/notas/carga/{curso_id}/{etapa}', [NotaController::class, 'cargaEtapa'])->name('notas.carga_etapa');
Route::post('/notas/carga/{curso_id}/{etapa}', [NotaController::class, 'guardarEtapa'])->name('notas.guardar_etapa');
Route::get('/notas', [NotaController::class, 'index'])->name('notas.index');
Route::get('/notas/curso/{id}', [NotaController::class, 'show'])->name('notas.show');
Route::get('/notas/curso/{curso_id}/materia/{materia_id}', [NotaController::class, 'ingresar'])->name('notas.ingresar');
Route::post('/notas/guardar', [NotaController::class, 'store'])->name('notas.store');

// Historia Académica
Route::prefix('historial')->group(function () {
    Route::get('/{alumno}', [HistorialAcademicoController::class, 'index'])->name('historial.index'); // Ver historial del alumno
    Route::get('/{alumno}/registrar', [HistorialAcademicoController::class, 'registrar'])->name('historial.registrar'); // Formulario para inscribir en un curso
    Route::post('/{alumno}/registrar', [HistorialAcademicoController::class, 'guardar'])->name('historial.guardar'); // Guardar inscripción
    Route::get('/{alumno}/cargar/{id_historial}', [HistorialAcademicoController::class, 'cargarNotas'])->name('historial.cargar'); // Ver notas de historial
    Route::post('/{alumno}/cargar/{id_historial}', [HistorialAcademicoController::class, 'guardarNotas'])->name('historial.guardarNotas'); // Guardar notas en historial
    Route::get('/historial/{alumno}/cooperadora/editar', [HistorialAcademicoController::class, 'editarCooperadora'])
        ->name('historial.editarCooperadora'); // Mostrar formulario
    Route::post('/historial/{alumno}/cooperadora/actualizar', [HistorialAcademicoController::class, 'actualizarCooperadora'])
        ->name('historial.actualizarCooperadora'); // Actualizar valor cooperadora
    Route::delete('/historial/{historial}', [HistorialAcademicoController::class, 'destroy'])
        ->name('historial.destroy');
});

//Preceptores
Route::resource('preceptors', PreceptorController::class);
//
//Docentes
Route::resource('docentes', DocenteController::class);
//
//Materias
Route::resource('materias', MateriaController::class);
//
Route::get('/info', function () {
    return view('layouts.info'); // Ajusta según el nombre real de tu vista
})->name('info');
// Ruta raíz que redirige a /home
Route::get('/', function () {
    return redirect('/home');
});
