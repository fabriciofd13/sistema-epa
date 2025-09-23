<?php

namespace App\Http\Controllers;

use App\Models\CursoDivision;
use App\Models\Alumno;
use App\Models\HistorialAcademico;
use App\Models\Preceptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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

    /* public function show($id)
    {
        $curso = CursoDivision::with(['historialAcademico.alumno' => function ($query) {
            $query->orderBy('apellido')->orderBy('nombre');
        }])->findOrFail($id);

        return view('cursos.show', compact('curso'));
    } */
    public function show($id)
    {
        $curso = CursoDivision::with([
            'historialAcademico.alumno' => function ($q) {
                $q->orderBy('apellido')->orderBy('nombre');
            },
            'historialAcademico'
        ])->findOrFail($id);

        // === Previas por alumno en TODA su historia académica ===
        $alumnoIds = $curso->historialAcademico->pluck('id_alumno')->unique()->values();

        // Traer TODOS los historiales de esos alumnos (sin filtrar por año)
        $historialesAll = \App\Models\HistorialAcademico::with(['curso.materias', 'curso'])
            ->whereIn('id_alumno', $alumnoIds)
            ->get();

        // Traer TODAS las notas de esos historiales
        $notasAll = \App\Models\Nota::whereIn('id_historial_academico', $historialesAll->pluck('id'))
            ->get()
            ->keyBy(fn($n) => $n->id_historial_academico . '-' . $n->id_materia);

        // Calcular previas para cada alumno
        $previasPorAlumno = [];
        foreach ($alumnoIds as $alumnoId) {
            $materiasAdeudadas = [];
            $faltanCargas = false;

            $misHistoriales = $historialesAll->where('id_alumno', $alumnoId);

            foreach ($misHistoriales as $hist) {
                // Si el curso no tiene materias asociadas, no podemos evaluar: marcamos faltante
                if (!($hist->curso && $hist->curso->materias)) {
                    $faltanCargas = true;
                    continue;
                }

                foreach ($hist->curso->materias as $materia) {
                    $key  = $hist->id . '-' . $materia->id;
                    $nota = $notasAll->get($key);

                    // Si no hay nota_final cargada, faltan datos
                    if (!$nota || is_null($nota->nota_final)) {
                        $faltanCargas = true;
                        continue;
                    }

                    $final = (float)$nota->nota_final;
                    $dic   = is_null($nota->nota_diciembre) ? null : (float)$nota->nota_diciembre;
                    $feb   = is_null($nota->nota_febrero)   ? null : (float)$nota->nota_febrero;
                    $prev  = is_null($nota->previa)         ? null : (float)$nota->previa;

                    $adeuda = $final < 6
                        && (($dic === null) || $dic < 6)
                        && (($feb === null) || $feb < 6)
                        && (($prev === null) || $prev < 6);

                    if ($adeuda) {
                        // Guardamos con el año lectivo al que pertenece esa materia
                        $materiasAdeudadas[] = $materia->nombre . ' [' . $materia->anio . '] ' . ' (' . $hist->anio_lectivo . ')';
                    }
                }
            }

            $status  = $faltanCargas ? 'faltan' : 'ok';
            $count   = $faltanCargas ? 0 : count($materiasAdeudadas);
            $preview = implode(', ', array_slice($materiasAdeudadas, 0, 2));
            if (count($materiasAdeudadas) > 2) {
                $preview .= '…';
            }

            $previasPorAlumno[$alumnoId] = [
                'status'  => $status,    // 'faltan' | 'ok'
                'count'   => $count,     // número de adeudadas
                'preview' => $preview,   // breve detalle
                // 'full' => $materiasAdeudadas, // si querés usarlo como tooltip
            ];
        }

        return view('cursos.show', compact('curso', 'previasPorAlumno'));
    }

    public function imprimir($id)
    {
        $curso = CursoDivision::with([
            'historialAcademico.alumno' => function ($q) {
                $q->orderBy('apellido')->orderBy('nombre');
            },
            'preceptor'
        ])->findOrFail($id);

        // === Previas en TODA la historia académica de cada alumno ===
        $alumnoIds = $curso->historialAcademico->pluck('id_alumno')->unique()->values();
        $historialesAll = \App\Models\HistorialAcademico::with(['curso.materias', 'curso'])
            ->whereIn('id_alumno', $alumnoIds)
            ->get();

        $notasAll = \App\Models\Nota::whereIn('id_historial_academico', $historialesAll->pluck('id'))
            ->get()
            ->keyBy(fn($n) => $n->id_historial_academico . '-' . $n->id_materia);

        $previasPorAlumno = [];
        foreach ($alumnoIds as $alumnoId) {
            $materiasAdeudadas = [];
            $faltanCargas = false;

            foreach ($historialesAll->where('id_alumno', $alumnoId) as $hist) {
                if (!($hist->curso && $hist->curso->materias)) {
                    $faltanCargas = true;
                    continue;
                }

                foreach ($hist->curso->materias as $materia) {
                    $key  = $hist->id . '-' . $materia->id;
                    $nota = $notasAll->get($key);

                    if (!$nota || is_null($nota->nota_final)) {
                        $faltanCargas = true;
                        continue;
                    }

                    $final = (float)$nota->nota_final;
                    $dic   = is_null($nota->nota_diciembre) ? null : (float)$nota->nota_diciembre;
                    $feb   = is_null($nota->nota_febrero)   ? null : (float)$nota->nota_febrero;
                    $prev  = is_null($nota->previa)         ? null : (float)$nota->previa;

                    $adeuda = $final < 6
                        && (($dic === null) || $dic < 6)
                        && (($feb === null) || $feb < 6)
                        && (($prev === null) || $prev < 6);

                    if ($adeuda) {
                        $materiasAdeudadas[] = $materia->nombre . ' [' . $materia->anio . '] (' . $hist->anio_lectivo . ')';
                    }
                }
            }

            $status  = $faltanCargas ? 'faltan' : 'ok';
            $count   = $faltanCargas ? 0 : count($materiasAdeudadas);
            $preview = implode(', ', array_slice($materiasAdeudadas, 0, 3));
            if (count($materiasAdeudadas) > 3) {
                $preview .= '…';
            }

            $previasPorAlumno[$alumnoId] = [
                'status'  => $status,
                'count'   => $count,
                'preview' => $preview,
            ];
        }

        // Datos del membrete (ajustá a tu config)
        $school = [
            'name'    => 'Escuela Provincial de Artes N°1 “Medardo Pantoja”',
            'address' => 'Sistema REGLA',
            'phone'   => 'www.escueladeartes1.edu.ar',
        ];

        $pdf = Pdf::loadView('pdf.lista_curso', [
            'curso'            => $curso,
            'previasPorAlumno' => $previasPorAlumno,
            'school'           => $school,
            'generado'         => now()->format('d/m/Y H:i'),
        ])->setPaper('legal', 'portrait'); // mismo tamaño y orientación que tu ficha

        return $pdf->stream('curso_' . $curso->nombre . '_' . $curso->anio_lectivo . '.pdf');
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

    public function buscar(Request $request)
    {
        $query = $request->input('q');

        $cursos = CursoDivision::withCount('historialAcademico') // Cantidad de alumnos
            ->with('preceptor:id,nombre,apellido')              // Traer preceptor
            ->where('nombre', 'ILIKE', "%{$query}%")
            ->orWhere('anio_lectivo', 'ILIKE', "%{$query}%")
            ->orderBy('anio_lectivo', 'desc')
            ->limit(20)
            ->get();

        return response()->json($cursos->map(function ($c) {
            return [
                'id'               => $c->id,
                'nombre'           => $c->nombre,
                'anio_lectivo'     => $c->anio_lectivo,
                'cantidad_alumnos' => $c->historial_academico_count ?? 0,
                'preceptor'        => $c->preceptor ? $c->preceptor->apellido . ' ' . $c->preceptor->nombre : 'Sin asignar',
            ];
        }));
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
