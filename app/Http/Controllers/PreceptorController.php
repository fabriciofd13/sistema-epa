<?php

namespace App\Http\Controllers;

use App\Models\Preceptor;
use App\Http\Requests\StorePreceptorRequest;
use App\Http\Requests\UpdatePreceptorRequest;
use App\Models\Barrio;
use App\Models\CursoDivision;
use App\Models\Localidad;
use Illuminate\Http\Request;

class PreceptorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // Puedes ajustar la paginación o filtros según necesidad
        $preceptors = Preceptor::orderBy('apellido')->paginate(10);
        return view('preceptors.index', compact('preceptors'));
    }


    public function create()
    {
        $localidades = Localidad::all();
        $barrios = Barrio::all();
        return view('preceptors.create', compact('localidades', 'barrios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'apellido' => 'required|max:100',
            'nombre' => 'required|max:100',
            'fecha_nacimiento' => 'required|date',
        ]);

        $data = $request->all();
        $data['create_user_id'] = auth()->id(); // usuario autenticado

        Preceptor::create($data);

        return redirect()->route('preceptors.index')
            ->with('success', 'Preceptor creado exitosamente.');
    }

    public function show(Preceptor $preceptor)
    {
        return view('preceptors.show', compact('preceptor'));
    }

    public function edit($id)
    {
        $preceptor = Preceptor::findOrFail($id);
        $barrios = Barrio::all(); // asumiendo que tenés modelos para estos
        $localidades = Localidad::all();

        return view('preceptors.edit', compact('preceptor', 'barrios', 'localidades'));
    }

    public function update(Request $request, $id)
    {
        $preceptor = Preceptor::findOrFail($id);

        $request->validate([
            'apellido' => 'required|max:100',
            'nombre' => 'required|max:100',
            'fecha_nacimiento' => 'required|date',
            // más validaciones...
        ]);

        $data = $request->all();
        $data['update_user_id'] = auth()->id();

        $preceptor->update($data);

        return redirect()->route('preceptors.index')->with('success', 'Preceptor actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $preceptor = Preceptor::findOrFail($id);
        $preceptor->delete();

        return redirect()->route('preceptors.index')->with('success', 'Preceptor eliminado correctamente.');
    }
    public function cursosAsignados($id)
    {
        $preceptor = Preceptor::with('cursos')->findOrFail($id);
        return view('preceptors.cursos', compact('preceptor'));
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
