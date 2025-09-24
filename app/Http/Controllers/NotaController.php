<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Http\Requests\StoreNotaRequest;
use App\Http\Requests\UpdateNotaRequest;
use App\Models\Alumno;
use App\Models\CursoDivision;
use App\Models\HistorialAcademico;
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
        $cursos = CursoDivision::orderBy('anio_lectivo', 'desc')
            ->orderBy('id', 'asc')
            ->get();

        $cursosPorAnio = $cursos->groupBy('anio_lectivo');

        return view('notas.index', compact('cursosPorAnio'));
    }

    public function show($id)
    {
        $curso = CursoDivision::findOrFail($id);
        $materias = Materia::where('anio', $curso->anio)->get();
        return view('notas.show', compact('curso', 'materias'));
    }

    public function ingresar($curso_id, $materia_id)
    {
        // Buscar el curso
        $curso = CursoDivision::findOrFail($curso_id);

        // Buscar la materia
        $materia = Materia::findOrFail($materia_id);

        // Buscar todos los historiales académicos de ese curso y año lectivo
        $historiales = HistorialAcademico::where('id_curso', $curso->id)
            ->where('anio_lectivo', $curso->anio_lectivo)
            ->with(['alumno', 'notas' => function ($query) use ($materia_id) {
                $query->where('id_materia', $materia_id);
            }])
            ->get();

        return view('notas.ingresar', compact('historiales', 'materia_id', 'materia', 'curso'));
    }
    public function store(Request $request)
    {
        foreach ($request->notas as $historial_id => $notas) {
            Nota::updateOrCreate(
                [
                    'id_historial_academico' => $historial_id,
                    'id_materia' => $request->id_materia
                ],
                [
                    'primer_trimestre' => $notas['primer_trimestre'] ?? null,
                    'segundo_trimestre' => $notas['segundo_trimestre'] ?? null,
                    'tercer_trimestre' => $notas['tercer_trimestre'] ?? null,
                    'nota_final' => $notas['nota_final'] ?? null,
                    'nota_diciembre' => $notas['nota_diciembre'] ?? null,
                    'nota_febrero' => $notas['nota_febrero'] ?? null,
                    'previa' => $notas['previa'] ?? null,
                    'definitiva' => $notas['definitiva'] ?? null,
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

        // Obtener alumnos inscriptos en ese curso y año lectivo
        $historiales = HistorialAcademico::where('id_curso', $curso_id)
            ->where('anio_lectivo', $curso->anio_lectivo)
            ->with('alumno')
            ->get();

        $alumnos = $historiales->pluck('alumno');
        $materias = Materia::where('anio', $curso->anio)->get();

        // Obtener las notas existentes
        $notas = Nota::whereIn('id_historial_academico', $historiales->pluck('id'))
            ->whereIn('id_materia', $materias->pluck('id'))
            ->get()
            ->keyBy(function ($nota) {
                return $nota->id_historial_academico . '-' . $nota->id_materia;
            });

        return view('notas.cargar_etapa', compact('curso', 'alumnos', 'materias', 'notas', 'etapa', 'historiales'));
    }

    public function guardarEtapa(Request $request, $curso_id, $etapa)
    {
        foreach ($request->notas as $historial_id => $materia_notas) {
            foreach ($materia_notas as $materia_id => $nota) {
                Nota::updateOrCreate(
                    [
                        'id_historial_academico' => $historial_id,
                        'id_materia' => $materia_id
                    ],
                    [
                        $etapa => ($nota === null || $nota === '') ? null : $nota,
                        'update_user_id' => auth()->id(),
                        'create_user_id' => Nota::where('id_historial_academico', $historial_id)
                            ->where('id_materia', $materia_id)
                            ->exists() ? null : auth()->id()
                    ]
                );
            }
        }

        return redirect()->route('notas.carga_etapa', ['curso_id' => $curso_id, 'etapa' => $etapa])
            ->with('success', 'Notas actualizadas correctamente.');
    }

    public function resumen($curso_id, $materia_id)
    {
        $curso   = CursoDivision::findOrFail($curso_id);
        $materia = Materia::findOrFail($materia_id);

        // Historales del curso en el año lectivo del curso
        $historiales = HistorialAcademico::where('id_curso', $curso->id)
            ->where('anio_lectivo', $curso->anio_lectivo)
            ->get();

        $historialIds = $historiales->pluck('id');

        // Todas las notas de esa materia en esos historiales
        $notas = Nota::whereIn('id_historial_academico', $historialIds)
            ->where('id_materia', $materia_id)
            ->get();

        // Inicializar todas las etapas (CORRECTO)
        $estadisticas = [
            'primer_trimestre'  => ['total' => 0, 'aprobados' => 0, 'desaprobados' => 0, 'aplazados' => 0],
            'segundo_trimestre' => ['total' => 0, 'aprobados' => 0, 'desaprobados' => 0, 'aplazados' => 0],
            'tercer_trimestre'  => ['total' => 0, 'aprobados' => 0, 'desaprobados' => 0, 'aplazados' => 0],
            'nota_final'        => ['total' => 0, 'aprobados' => 0, 'desaprobados' => 0, 'aplazados' => 0],
            'nota_diciembre'    => ['total' => 0, 'aprobados' => 0, 'desaprobados' => 0, 'aplazados' => 0],
            'nota_febrero'      => ['total' => 0, 'aprobados' => 0, 'desaprobados' => 0, 'aplazados' => 0],
        ];

        // Etapas a considerar
        $trimestres = ['primer_trimestre', 'segundo_trimestre', 'tercer_trimestre'];
        $cierres    = ['nota_final', 'nota_diciembre', 'nota_febrero'];

        foreach ($notas as $nota) {
            // Trimestres
            foreach ($trimestres as $etapa) {
                $valor = $nota->$etapa;
                if ($valor !== null && $valor !== '') {
                    $estadisticas[$etapa]['total']++;
                    $v = (float)$valor;

                    if (in_array((int)$v, [1, 2, 3], true)) {
                        $estadisticas[$etapa]['aplazados']++;
                    } elseif (in_array((int)$v, [4, 5], true)) {
                        $estadisticas[$etapa]['desaprobados']++;
                    } elseif ($v >= 6) {
                        $estadisticas[$etapa]['aprobados']++;
                    }
                }
            }

            // Final / Diciembre / Febrero
            foreach ($cierres as $etapa) {
                $valor = $nota->$etapa;
                if ($valor !== null && $valor !== '') {
                    $estadisticas[$etapa]['total']++;
                    $v = (float)$valor;

                    if (in_array((int)$v, [1, 2, 3], true)) {
                        $estadisticas[$etapa]['aplazados']++;
                    } elseif (in_array((int)$v, [4, 5], true)) {
                        $estadisticas[$etapa]['desaprobados']++;
                    } elseif ($v >= 6) {
                        $estadisticas[$etapa]['aprobados']++;
                    }
                }
            }
        }

        return view('notas.resumen', [
            'curso'   => $curso,
            'materia' => $materia,
            'resumen' => $estadisticas,
        ]);
    }

    public function graficosTrimestre($curso_id)
    {
        $curso = CursoDivision::findOrFail($curso_id);
        $materias = Materia::where('anio', $curso->anio)->get();

        $historiales = HistorialAcademico::where('id_curso', $curso->id)
            ->where('anio_lectivo', $curso->anio_lectivo)
            ->get();

        $historialIds = $historiales->pluck('id');

        $datos = [
            'primer_trimestre' => ['materias' => []],
            'segundo_trimestre' => ['materias' => []],
            'tercer_trimestre' => ['materias' => []],
        ];

        foreach ($materias as $materia) {
            $notas = Nota::whereIn('id_historial_academico', $historialIds)
                ->where('id_materia', $materia->id)
                ->get();

            foreach (['primer_trimestre', 'segundo_trimestre', 'tercer_trimestre'] as $etapa) {
                $resumen = [
                    'nombre' => $materia->nombre,
                    'aprobados' => 0,
                    'desaprobados' => 0,
                    'aplazados' => 0
                ];

                foreach ($notas as $nota) {
                    $valor = $nota->$etapa;
                    if (!is_null($valor)) {
                        if ($valor >= 6) {
                            $resumen['aprobados']++;
                        } elseif (in_array($valor, [4, 5])) {
                            $resumen['desaprobados']++;
                        } elseif (in_array($valor, [1, 2, 3])) {
                            $resumen['aplazados']++;
                        }
                    }
                }

                $datos[$etapa]['materias'][] = $resumen;
            }
        }

        return view('notas.graficos_trimestre', compact('curso', 'datos'));
    }
}
