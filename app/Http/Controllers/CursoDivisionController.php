<?php

namespace App\Http\Controllers;

use App\Models\CursoDivision;
use App\Models\Alumno;
use App\Models\HistorialAcademico;
use App\Models\Preceptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CursoDivisionController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursosAgrupados = CursoDivision::with(['preceptor', 'historialAcademico'])
            ->orderBy('anio_lectivo', 'desc') // 👈 ordena por año lectivo descendente
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy('anio_lectivo');

        return view('cursos.index', compact('cursosAgrupados'));
    }

    public function show($id)
    {
        $curso = CursoDivision::with(['historialAcademico.alumno' => function ($query) {
            $query->orderBy('apellido')->orderBy('nombre');
        }])->findOrFail($id);

        return view('cursos.show', compact('curso'));
    }

    public function getAlumnosSinCurso($id)
    {
        $curso = CursoDivision::with('historialAcademico.alumno')->findOrFail($id);

        $alumnosEnCurso = $curso->historialAcademico->pluck('id_alumno');

        $alumnosSinCurso = Alumno::whereNotIn('id', $alumnosEnCurso)
            ->whereDoesntHave('historialAcademico', function ($query) use ($curso) {
                $query->where('anio_lectivo', $curso->anio_lectivo);
            })
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view('cursos.agregar-alumnos', compact('curso', 'alumnosSinCurso'));
    }

    public function agregarAlumnosCurso(Request $request, $id)
    {
        $curso = CursoDivision::findOrFail($id);

        // Convertir JSON string a array
        $alumnos = json_decode($request->input('alumnos', '[]'), true);

        if (!is_array($alumnos)) {
            return redirect()->back()->with('error', 'Error en la selección de alumnos.');
        }

        foreach ($alumnos as $alumnoId) {
            HistorialAcademico::create([
                'id_alumno' => $alumnoId,
                'id_curso' => $curso->id,
                'anio_lectivo' => $curso->anio_lectivo
            ]);
        }

        return redirect()->route('cursos.show', $curso->id)->with('success', 'Lista actualizada correctamente.');
    }

    public function asignarPreceptorForm($id)
    {
        $curso = CursoDivision::findOrFail($id);
        $preceptores = Preceptor::orderBy('apellido')->get();

        return view('cursos.asignar_preceptor', compact('curso', 'preceptores'));
    }

    public function asignarPreceptor(Request $request, $id)
    {
        $request->validate([
            'id_preceptor' => 'required|exists:preceptors,id'
        ]);

        $curso = CursoDivision::findOrFail($id);
        $curso->id_preceptor = $request->id_preceptor;
        $curso->update_user_id = auth()->id();
        $curso->save();

        return redirect()->route('cursos.show', $curso->id)
            ->with('success', 'Preceptor asignado correctamente al curso.');
    }

    public function misCursos()
    {
        $user = Auth::user();

        if (!$user->id_preceptor) {
            abort(403, 'Este usuario no es preceptor.');
        }

        $cursos = CursoDivision::where('id_preceptor', $user->id_preceptor)
            ->orderBy('anio_lectivo', 'desc')
            ->get();

        return view('preceptors.mis_cursos', compact('cursos'));
    }
}
