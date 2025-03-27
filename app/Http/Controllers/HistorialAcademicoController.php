<?php

namespace App\Http\Controllers;

use App\Models\HistorialAcademico;
use App\Http\Requests\StoreHistorialAcademicoRequest;
use App\Http\Requests\UpdateHistorialAcademicoRequest;
use App\Models\Alumno;
use App\Models\CursoDivision;
use App\Models\Materia;
use App\Models\Nota;
use Illuminate\Http\Request; // No debe ser Client
class HistorialAcademicoController extends Controller
{
    /**
     * Constructor del controlador.
     * Aquí le indicamos que todos los métodos deben pasar por el middleware "auth".
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Muestra la lista de inscripciones del alumno.
     */
    /* public function index(Alumno $alumno)
    {
        $historiales = HistorialAcademico::where('id_alumno', $alumno->id)->get();
        
        return view('historial.index', compact('alumno', 'historiales'));
    } */
    public function index(Alumno $alumno)
    {
        $historiales = HistorialAcademico::where('id_alumno', $alumno->id)
            ->with(['curso.materias', 'curso']) // Carga las materias del curso
            ->get();

        $notas = Nota::whereIn('id_historial_academico', $historiales->pluck('id'))
            ->get()
            ->keyBy(function ($nota) {
                return $nota->id_historial_academico . '-' . $nota->id_materia;
            });

        return view('historial.index', compact('alumno', 'historiales', 'notas'));
    }


    /**
     * Muestra el formulario para registrar una nueva inscripción.
     */
    public function registrar($id)
    {
        $alumno = Alumno::findOrFail($id);
        $cursos = CursoDivision::orderBy('anio_lectivo', 'desc')->get();
        return view('historial.registrar', compact('alumno', 'cursos'));
    }

    /**
     * Guarda la inscripción del alumno en un curso y año lectivo.
     */
    public function guardar(Request $request, $id)
    {
        $request->validate([
            'anio_lectivo' => 'required|integer',
            'id_curso' => 'required|exists:curso_divisions,id',
        ]);

        $alumno = Alumno::findOrFail($id);

        // Guardar la inscripción en el historial académico
        HistorialAcademico::create([
            'id_alumno' => $alumno->id,
            'id_curso' => $request->id_curso,
            'anio_lectivo' => $request->anio_lectivo,
            'pago_cooperadora' => $request->cooperadora,
            'create_user_id' => auth()->id(),
        ]);

        return redirect()->route('historial.index', $alumno->id)->with('success', 'Inscripción guardada correctamente.');
    }
    public function guardarNotas(Request $request, $id_alumno, $id_historial)
    {
        $alumno = Alumno::findOrFail($id_alumno);
        $historial = HistorialAcademico::findOrFail($id_historial);

        foreach ($request->notas as $materia_id => $notaData) {
            Nota::updateOrCreate(
                [
                    'id_historial_academico' => $historial->id,
                    'id_materia' => $materia_id
                ],
                [
                    'primer_trimestre' => $notaData['primer_trimestre'] ?? null,
                    'segundo_trimestre' => $notaData['segundo_trimestre'] ?? null,
                    'tercer_trimestre' => $notaData['tercer_trimestre'] ?? null,
                    'nota_final' => $notaData['nota_final'] ?? null,
                    'nota_diciembre' => $notaData['nota_diciembre'] ?? null,
                    'nota_febrero' => $notaData['nota_febrero'] ?? null,
                    'previa' => $notaData['previa'] ?? null,
                    'definitiva' => $notaData['definitiva'] ?? null,
                    'update_user_id' => auth()->id(),
                ]
            );
        }

        return redirect()->route('historial.index', $alumno->id)->with('success', 'Notas guardadas correctamente.');
    }

    public function cargarNotas($id_alumno, $id_historial)
    {
        $alumno = Alumno::findOrFail($id_alumno);
        $historial = HistorialAcademico::findOrFail($id_historial);

        // Obtener el curso al que pertenece el historial
        $curso = CursoDivision::findOrFail($historial->id_curso);

        // Filtrar las materias según el año del curso
        $materias = Materia::where('anio', $curso->anio)->get();

        // Obtener notas del historial académico del alumno
        $notas = Nota::where('id_historial_academico', $historial->id)->get()->keyBy('id_materia');

        return view('historial.cargar', compact('alumno', 'curso', 'materias', 'notas', 'historial'));
    }
    public function editarCooperadora($alumnoId)
    {
        // Obtén al alumno
        $alumno = Alumno::findOrFail($alumnoId);

        // Busca el registro de historial_academicos que desees actualizar.
        // Por ejemplo, podrías filtrar por año lectivo, o tomar el más reciente, etc.
        // Aquí te muestro un ejemplo genérico que obtiene uno específico:
        $historial = HistorialAcademico::where('id_alumno', $alumnoId)
            ->orderBy('anio_lectivo', 'desc')
            ->firstOrFail();

        // Devuelves una vista con el formulario para editar 'pago_cooperadora'
        return view('historial.editarCooperadora', compact('alumno', 'historial'));
    }
    public function actualizarCooperadora(Request $request, $alumnoId)
    {
        // Validación sencilla
        $request->validate([
            'pago_cooperadora' => 'required|integer|min:0|max:50000',
        ]);

        // Obtén al alumno (para redirecciones o comprobaciones)
        $alumno = Alumno::findOrFail($alumnoId);

        // Selecciona el historial correspondiente.
        // De nuevo, aquí ajusta a la lógica que use tu sistema
        $historial = HistorialAcademico::where('id_alumno', $alumnoId)
            ->orderBy('anio_lectivo', 'desc')
            ->firstOrFail();

        // Actualiza el valor
        $historial->pago_cooperadora = $request->pago_cooperadora;

        // (Opcional) Si manejas auditoría:
        $historial->update_user_id = auth()->id();

        $historial->save();

        // Redireccionas al índice del historial o donde necesites
        return redirect()->route('historial.index', $alumnoId)
            ->with('success', 'Valor de la cooperadora actualizado correctamente.');
    }
    public function destroy($historialId)
    {
        // Buscas el historial por su ID
        $historial = HistorialAcademico::findOrFail($historialId);

        // Elimina el historial
        // Debido a la relación con ON DELETE CASCADE,
        // las notas asociadas se eliminarán automáticamente.
        $historial->delete();

        // Redirige a la vista que muestra los historiales (o donde prefieras),
        // con un mensaje de éxito
        return redirect()->back()
            ->with('success', 'Inscripción eliminada correctamente, junto con sus notas asociadas.');
    }
}
