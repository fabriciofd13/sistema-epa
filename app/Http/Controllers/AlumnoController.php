<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Barrio;
use App\Models\CursoDivision;
use App\Models\HistorialAcademico;
use App\Models\Localidad;
use App\Models\Materia;
use App\Models\Nota;
use Illuminate\Http\Request; // No debe ser Client
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    /**
     * Constructor del controlador.
     * Aquí le indicamos que todos los métodos deben pasar por el middleware "auth".
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Método para mostrar el listado de alumnos
    public function index()
    {
        $alumnos = Alumno::with('cursoDivision')->get();
        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        $localidades = Localidad::all();
        $barrios = Barrio::all();
        return view('alumnos.create', compact('localidades', 'barrios'));
    }

    public function store(Request $request)
    {
        // Valida que el campo dni sea único en la tabla 'alumnos'
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'dni' => 'required|unique:alumnos,dni',
            // ...continúa con las demás validaciones que necesites...
        ], [
            // Puedes personalizar el mensaje de error
            'dni.unique' => 'El DNI ingresado ya se encuentra registrado.',
        ]);

        // Si la validación pasa, creamos el alumno
        Alumno::create($request->all());

        return redirect()->route('alumnos.create')
            ->with('success', 'Alumno registrado con éxito');
    }
    public function checkDni(Request $request)
    {
        $dni = $request->get('dni');
        $alumno = Alumno::where('dni', $dni)->first();

        if ($alumno) {
            // Si existe un alumno con ese DNI, devolvemos JSON con un flag y la ruta de edición
            $editUrl = route('alumnos.edit', $alumno->id);
            return response()->json([
                'exists'   => true,
                'edit_url' => $editUrl,
            ]);
        }

        // Si no existe, devolvemos que no hay coincidencia
        return response()->json(['exists' => false]);
    }

    public function verNotasEditables($id)
    {
        $alumno = Alumno::with('cursoDivision')->findOrFail($id);
        $curso = $alumno->cursoDivision;

        if (!$curso) {
            return redirect()->route('alumnos.index')->with('error', 'El alumno no tiene un curso asignado.');
        }

        // Obtener las materias correspondientes al año del curso del alumno
        $materias = Materia::where('anio', $curso->anio)->get();

        // Obtener las notas del alumno
        $notas = Nota::where('id_alumno', $id)
            ->whereIn('id_materia', $materias->pluck('id'))
            ->get()
            ->keyBy('id_materia');

        return view('alumnos.notas_editables', compact('alumno', 'curso', 'materias', 'notas'));
    }

    public function guardarNotas(Request $request, $id)
    {
        $alumno = Alumno::findOrFail($id);

        foreach ($request->notas as $materia_id => $notaData) {
            Nota::updateOrCreate(
                ['id_alumno' => $alumno->id, 'id_materia' => $materia_id],
                [
                    'primer_trimestre' => $notaData['primer_trimestre'] ?? null,
                    'segundo_trimestre' => $notaData['segundo_trimestre'] ?? null,
                    'tercer_trimestre' => $notaData['tercer_trimestre'] ?? null,
                    'nota_final' => $notaData['nota_final'] ?? null,
                    'nota_diciembre' => $notaData['nota_diciembre'] ?? null,
                    'nota_febrero' => $notaData['nota_febrero'] ?? null,
                    'previa' => $notaData['previa'] ?? null,
                    'update_user_id' => auth()->id(),
                ]
            );
        }

        return redirect()->route('alumnos.notas.editar', $alumno->id)->with('success', 'Notas actualizadas correctamente.');
    }

    public function buscar(Request $request)
    {
        $query = $request->input('q');

        $alumnos = Alumno::where('apellido', 'ILIKE', "%{$query}%")
            ->orWhere('nombre', 'ILIKE', "%{$query}%")
            ->orWhere('dni', 'ILIKE', "%{$query}%")
            ->orderBy('apellido')
            ->limit(20)
            ->get();

        return response()->json($alumnos);
    }




    /* public function show($id)
    {
        $alumno = Alumno::findOrFail($id);

        // Año actual (para detectar curso actual)
        $anioActual = Carbon::now()->year;

        // Curso actual desde historial_academicos si coincide con el año actual
        // Ajustá nombres reales de columnas en curso_divisions si difieren (ej: nombre/division/anio)
        $cursoActual = DB::table('historial_academicos as ha')
            ->join('curso_divisions as c', 'c.id', '=', 'ha.id_curso')
            ->where('ha.id_alumno', $alumno->id)
            ->where('ha.anio_lectivo', $anioActual)
            ->select(
                'c.id as curso_id',
                'c.nombre as curso_nombre',
                DB::raw('ha.anio_lectivo as anio'), // alias uniforme para la vista
            )
            ->first();

        // (Opcional) si tenés relación con preceptor en curso_divisions, traela acá
        $preceptorActual = null;
        // if (isset($cursoActual->curso_id)) {
        //     $preceptorActual = DB::table('preceptors as p')
        //         ->join('curso_divisions as c', 'c.id_preceptor', '=', 'p.id')
        //         ->where('c.id', $cursoActual->curso_id)
        //         ->select('p.apellido', 'p.nombre')
        //         ->first();
        // }

        // Foto opcional (si tenés relación)
        $fotoUrl = null;
        if (method_exists($alumno, 'fotos')) {
            $fotoUrl = optional($alumno->fotos()->latest()->first())->url ?? null;
        }

        // Historial académico + notas + materias agrupado por año_lectivo
        $registros = DB::table('historial_academicos as ha')
            ->join('notas as n', 'n.id_historial_academico', '=', 'ha.id')
            ->join('materias as m', 'm.id', '=', 'n.id_materia')
            ->where('ha.id_alumno', $alumno->id)
            ->select([
                'ha.anio_lectivo',
                'm.nombre as materia',
                'n.primer_trimestre',
                'n.segundo_trimestre',
                'n.tercer_trimestre',
                // Promedio de trimestres no nulos
                DB::raw("
                ROUND(
                    (COALESCE(n.primer_trimestre,0) + COALESCE(n.segundo_trimestre,0) + COALESCE(n.tercer_trimestre,0))
                    / NULLIF(
                        (CASE WHEN n.primer_trimestre IS NULL THEN 0 ELSE 1 END
                        + CASE WHEN n.segundo_trimestre IS NULL THEN 0 ELSE 1 END
                        + CASE WHEN n.tercer_trimestre IS NULL THEN 0 ELSE 1 END), 0
                    )
                , 2
                ) as promedio
            "),
                'n.nota_final',
                'n.nota_diciembre as diciembre',
                'n.nota_febrero as febrero',
                'n.previa as previas',
                'n.definitiva',
            ])
            ->orderBy('ha.anio_lectivo', 'desc')
            ->get()
            ->groupBy('anio_lectivo');

        $notasPorAnio = $registros;

        return view('alumnos.show', [
            'alumno'          => $alumno,
            'fotoUrl'         => $fotoUrl,
            'cursoActual'     => $cursoActual,     // contiene curso_nombre y anio
            'preceptorActual' => $preceptorActual, // null si no lo cargás
            'notasPorAnio'    => $notasPorAnio,
        ]);
    } */
   public function show($id)
{
    $alumno = Alumno::findOrFail($id);

    $anioActual   = Carbon::now()->year;
    $anioAnterior = $anioActual - 1;

    // Curso actual (historial del año en curso)
    $cursoActual = DB::table('historial_academicos as ha')
        ->join('curso_divisions as c', 'c.id', '=', 'ha.id_curso')
        ->where('ha.id_alumno', $alumno->id)
        ->where('ha.anio_lectivo', $anioActual)
        ->select(
            'c.id as curso_id',
            'c.nombre as curso_nombre',
            DB::raw('ha.anio_lectivo as anio')
        )
        ->first();

    // Curso del año anterior (si existió)
    $cursoAnterior = DB::table('historial_academicos as ha')
        ->join('curso_divisions as c', 'c.id', '=', 'ha.id_curso')
        ->where('ha.id_alumno', $alumno->id)
        ->where('ha.anio_lectivo', $anioAnterior)
        ->select(
            'c.id as curso_id',
            'c.nombre as curso_nombre',
            DB::raw('ha.anio_lectivo as anio')
        )
        ->first();

    // (Opcional) Preceptor actual si tenés relación
    $preceptorActual = null;
    // if (isset($cursoActual->curso_id)) { ... }

    // Foto opcional
    $fotoUrl = null;
    if (method_exists($alumno, 'fotos')) {
        $fotoUrl = optional($alumno->fotos()->latest()->first())->url ?? null;
    }

    // Historial académico + notas + materias agrupado por año_lectivo (para las tablas)
    $registros = DB::table('historial_academicos as ha')
        ->join('notas as n', 'n.id_historial_academico', '=', 'ha.id')
        ->join('materias as m', 'm.id', '=', 'n.id_materia')
        ->where('ha.id_alumno', $alumno->id)
        ->select([
            'ha.anio_lectivo',
            'm.nombre as materia',
            'n.primer_trimestre',
            'n.segundo_trimestre',
            'n.tercer_trimestre',
            DB::raw("
                ROUND(
                    (COALESCE(n.primer_trimestre,0) + COALESCE(n.segundo_trimestre,0) + COALESCE(n.tercer_trimestre,0))
                    / NULLIF(
                        (CASE WHEN n.primer_trimestre IS NULL THEN 0 ELSE 1 END
                        + CASE WHEN n.segundo_trimestre IS NULL THEN 0 ELSE 1 END
                        + CASE WHEN n.tercer_trimestre IS NULL THEN 0 ELSE 1 END), 0
                    )
                , 2
                ) as promedio
            "),
            'n.nota_final',
            'n.nota_diciembre as diciembre',
            'n.nota_febrero as febrero',
            'n.previa as previas',
            'n.definitiva',
        ])
        ->orderBy('ha.anio_lectivo', 'desc')
        ->get()
        ->groupBy('anio_lectivo');

    $notasPorAnio = $registros;

    /*
     * === Previas (años anteriores) ===
     * Regla: adeuda si nota_final < 6 y (dic <6 o null) y (feb <6 o null) y (previa <6 o null).
     * Si falta nota_final en alguna materia de algún año, mostramos "Faltan notas".
     */
    $historiales = HistorialAcademico::where('id_alumno', $alumno->id)
        ->with(['curso.materias', 'curso'])
        ->get();

    $notas = Nota::whereIn('id_historial_academico', $historiales->pluck('id'))
        ->get()
        ->keyBy(fn($n) => $n->id_historial_academico . '-' . $n->id_materia);

    $materiasAdeudadas = [];
    $faltanCargas = false;

    foreach ($historiales as $hist) {
        // Solo años anteriores al actual
        if ((int)$hist->anio_lectivo >= (int)$anioActual) {
            continue;
        }
        if (!($hist->curso && $hist->curso->materias)) {
            $faltanCargas = true;
            continue;
        }
        foreach ($hist->curso->materias as $materia) {
            $key  = $hist->id . '-' . $materia->id;
            $nota = $notas->get($key);

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
                $materiasAdeudadas[] = $materia->nombre . ' (' . $hist->anio_lectivo . ')';
            }
        }
    }

    $previasStatus  = $faltanCargas ? 'faltan' : 'ok';
    $previasCount   = $faltanCargas ? 0 : count($materiasAdeudadas);
    $previasPreview = implode(', ', array_slice($materiasAdeudadas, 0, 2)) . (count($materiasAdeudadas) > 2 ? '…' : '');

    return view('alumnos.show', [
        'alumno'          => $alumno,
        'fotoUrl'         => $fotoUrl,
        'cursoActual'     => $cursoActual,
        'cursoAnterior'   => $cursoAnterior,
        'preceptorActual' => $preceptorActual,
        'notasPorAnio'    => $notasPorAnio,

        // Previas
        'previasStatus'   => $previasStatus,   // 'ok' | 'faltan'
        'previasCount'    => $previasCount,    // nº adeudadas (si ok)
        'previasPreview'  => $previasPreview,  // texto corto
        // 'previasFull'   => $materiasAdeudadas, // (opcional) lista completa
    ]);
}


    public function verNotas($id)
    {
        $alumno = Alumno::findOrFail($id);
        $curso = CursoDivision::find($alumno->id_curso);
        $notas = Nota::where('id_alumno', $id)
            ->with('asignatura') // Eager Loading de la relación
            ->orderBy('id_materia')
            ->get();

        return view('alumnos.notas', compact('alumno', 'curso', 'notas'));
    }
    // Mostrar el formulario de edición
    public function edit($id)
    {
        $localidades = Localidad::all();
        $barrios = Barrio::all();
        $alumno = Alumno::findOrFail($id);
        return view('alumnos.edit', compact('alumno', 'barrios', 'localidades'));
    }

    // Actualizar los datos del alumno en la base de datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni' => 'required|string|max:10|unique:alumnos,dni,' . $id,
            'fecha_nacimiento' => 'required|date',
        ]);

        $alumno = Alumno::findOrFail($id);
        $alumno->update($request->all());

        return redirect()->route('alumnos.edit', $alumno->id)->with('success', 'Alumno actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        //
    }

    //PDF

    public function pdfFichaAcademica($id)
    {
        $anioActual = (int) now()->year;
        $desde = 2020;

        $alumno = Alumno::with([
            // ⚠️ Ajustá el nombre de la relación según tu modelo: historialAcademico o historiales
            'historialAcademico' => function ($q) use ($desde) {
                $q->where('anio_lectivo', '>=', $desde)
                    ->with([
                        'curso:id,nombre,anio_lectivo,anio',
                        'notas' => function ($n) {
                            $n->with(['materia:id,nombre,anio'])
                                ->orderByRaw("COALESCE(definitiva, COALESCE(nota_final, COALESCE(tercer_trimestre, 0))) DESC");
                        }
                    ])
                    ->orderBy('anio_lectivo', 'desc'); // año actual primero
            }
        ])->findOrFail($id);

        $edad = $alumno->fecha_nacimiento
            ? Carbon::parse($alumno->fecha_nacimiento)->age
            : null;

        $school = [
            'name'    => 'Escuela Provincial de Artes N°1 “Medardo Pantoja”',
            'address' => 'Sistema REGLA',
            'phone'   => 'www.escueladeartes1.edu.ar',
            'slogan'  => 'Formación y Creatividad',
        ];

        $pdf = Pdf::loadView('pdf.ficha_academica', compact('alumno', 'school', 'anioActual', 'desde', 'edad'))
            ->setPaper('legal', 'portrait'); // Legal vertical


        return $pdf->stream('ficha_academica_' . $alumno->apellido . '_' . $alumno->nombre . '.pdf');
    }
}
