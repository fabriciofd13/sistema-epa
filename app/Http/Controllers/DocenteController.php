<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Http\Requests\StoreDocenteRequest;
use App\Http\Requests\UpdateDocenteRequest;
use App\Models\Barrio;
use App\Models\Localidad;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $docentes = Docente::orderBy('apellido')->paginate(10);
        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        $localidades = Localidad::all();
        $barrios = Barrio::all();
        return view('docentes.create', compact('localidades', 'barrios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'apellido' => 'required|max:100',
            'nombre' => 'required|max:100',
            'dni' => 'required|max:10|unique:docentes',
            'cuil' => 'required|max:15|unique:docentes',
            'fecha_nacimiento' => 'required|date',
        ]);

        $data = $request->all();
        $data['create_user_id'] = auth()->id();

        Docente::create($data);

        return redirect()->route('docentes.index')
            ->with('success', 'Docente creado exitosamente.');
    }

    public function show(Docente $docente)
    {
        return view('docentes.show', compact('docente'));
    }

    public function edit($id)
    {
        $docente = Docente::findOrFail($id);
        $localidades = Localidad::all();
        $barrios = Barrio::all();

        return view('docentes.edit', compact('docente', 'localidades', 'barrios'));
    }

    public function update(Request $request, $id)
    {
        $docente = Docente::findOrFail($id);

        $request->validate([
            'apellido' => 'required|max:100',
            'nombre' => 'required|max:100',
            'fecha_nacimiento' => 'required|date',
            // más validaciones si necesitás
        ]);

        $data = $request->all();
        $data['update_user_id'] = auth()->id();

        $docente->update($data);

        return redirect()->route('docentes.index')
            ->with('success', 'Docente actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $docente = Docente::findOrFail($id);
        $docente->delete();

        return redirect()->route('docentes.index')
            ->with('success', 'Docente eliminado correctamente.');
    }
}
