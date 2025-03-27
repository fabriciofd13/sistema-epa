<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Http\Requests\StoreNotaRequest;
use App\Http\Requests\UpdateNotaRequest;
use App\Models\Alumno;
use App\Models\CursoDivision;
use App\Models\Materia;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Constructor del controlador.
     * Aquí le indicamos que todos los métodos deben pasar por el middleware "auth".
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $cursos = CursoDivision::all();
        return view('notas.index', compact('cursos'));
    }

    public function show($id)
    {
        $curso = CursoDivision::findOrFail($id);
        $materias = Materia::where('anio', $curso->anio)->get();
        return view('notas.show', compact('curso', 'materias'));
    }

    public function ingresar($curso_id, $materia_id)
    {
        $materia = Materia::findOrFail($materia_id);
        $curso = CursoDivision::findOrFail($curso_id);
        $alumnos = Alumno::where('id_curso', $curso_id)
            ->with(['notas' => function ($query) use ($materia_id) {
                $query->where('id_materia', $materia_id);
            }])
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view('notas.ingresar', compact('alumnos', 'materia_id', 'materia', 'curso'));
    }
    public function store(Request $request)
    {
        foreach ($request->notas as $alumno_id => $notas) {
            Nota::updateOrCreate(
                ['id_alumno' => $alumno_id, 'id_materia' => $request->id_materia],
                [
                    'primer_trimestre' => $notas['primer_trimestre'] ?? null,
                    'segundo_trimestre' => $notas['segundo_trimestre'] ?? null,
                    'tercer_trimestre' => $notas['tercer_trimestre'] ?? null,
                    'nota_final' => $notas['nota_final'] ?? null,
                    'nota_diciembre' => $notas['nota_diciembre'] ?? null,
                    'nota_febrero' => $notas['nota_febrero'] ?? null,
                    'previa' => $notas['previa'] ?? null,
                    'create_user_id' => auth()->id(),
                    'update_user_id' => auth()->id(),
                ]
            );
        }
        return redirect()->route('notas.ingresar', [
            'curso_id' => $request->id_curso,
            'materia_id' => $request->id_materia
        ])->with('success', 'Notas guardadas correctamente.');
    }
    public function cargaEtapa($curso_id, $etapa)
    {
        $curso = CursoDivision::findOrFail($curso_id);
        $alumnos = Alumno::where('id_curso', $curso_id)->orderBy('apellido')->get();
        $materias = Materia::where('anio', $curso->anio)->get();

        // Obtener notas existentes
        $notas = Nota::whereIn('id_alumno', $alumnos->pluck('id'))
            ->whereIn('id_materia', $materias->pluck('id'))
            ->get()
            ->keyBy(function ($nota) {
                return $nota->id_alumno . '-' . $nota->id_materia;
            });

        return view('notas.cargar_etapa', compact('curso', 'alumnos', 'materias', 'notas', 'etapa'));
    }
    public function guardarEtapa(Request $request, $curso_id, $etapa)
    {
        foreach ($request->notas as $alumno_id => $materia_notas) {
            foreach ($materia_notas as $materia_id => $nota) {
                Nota::updateOrCreate(
                    ['id_alumno' => $alumno_id, 'id_materia' => $materia_id],
                    [$etapa => $nota]
                );
            }
        }

        return redirect()->route('notas.carga_etapa', ['curso_id' => $curso_id, 'etapa' => $etapa])
            ->with('success', 'Notas actualizadas correctamente.');
    }
}
