<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Barrio;
use App\Models\CursoDivision;
use App\Models\Localidad;
use App\Models\Materia;
use App\Models\Nota;
use Illuminate\Http\Request; // No debe ser Client

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


    public function show(Alumno $alumno)
    {
        //
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
        return view('alumnos.edit', compact('alumno','barrios','localidades'));
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
}
