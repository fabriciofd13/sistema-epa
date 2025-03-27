<?php

namespace App\Http\Controllers;

use App\Models\Preceptor;
use App\Http\Requests\StorePreceptorRequest;
use App\Http\Requests\UpdatePreceptorRequest;
use Illuminate\Http\Request;

class PreceptorController extends Controller
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
        // Puedes ajustar la paginación o filtros según necesidad
        $preceptors = Preceptor::orderBy('apellido')->paginate(10);
        return view('preceptors.index', compact('preceptors'));
    }

    /**
     * Muestra el formulario para crear un nuevo preceptor.
     */
    public function create()
    {
        return view('preceptors.create');
    }

    /**
     * Almacena un nuevo preceptor en la base de datos.
     */
    public function store(Request $request)
    {
        // Ejemplo de validación rápida (podrías usar FormRequest)
        $request->validate([
            'apellido' => 'required|max:100',
            'nombre' => 'required|max:100',
            'dni' => 'required|max:10|unique:preceptors,dni',
            'cuil' => 'required|max:15|unique:preceptors,cuil',
            'fecha_nacimiento' => 'required|date',
            // Agrega más validaciones según tus necesidades
        ]);

        Preceptor::create($request->all());

        return redirect()->route('preceptors.index')
            ->with('success', 'Preceptor creado exitosamente.');
    }

    /**
     * Muestra la información de un preceptor específico.
     */
    public function show(Preceptor $preceptor)
    {
        return view('preceptors.show', compact('preceptor'));
    }

    /**
     * Muestra el formulario para editar un preceptor específico.
     */
    public function edit(Preceptor $preceptor)
    {
        return view('preceptors.edit', compact('preceptor'));
    }

    /**
     * Actualiza un preceptor en la base de datos.
     */
    public function update(Request $request, Preceptor $preceptor)
    {
        // Validar (puede ser similar a store, pero recuerda unique:<tabla>,<campo>,<ignoreId>)
        $request->validate([
            'apellido' => 'required|max:100',
            'nombre' => 'required|max:100',
            'dni' => 'required|max:10|unique:preceptors,dni,' . $preceptor->id,
            'cuil' => 'required|max:15|unique:preceptors,cuil,' . $preceptor->id,
            'fecha_nacimiento' => 'required|date',
            // Agrega más validaciones según tus necesidades
        ]);

        $preceptor->update($request->all());

        return redirect()->route('preceptors.index')
            ->with('success', 'Preceptor actualizado correctamente.');
    }

    /**
     * Elimina un preceptor de la base de datos.
     */
    public function destroy(Preceptor $preceptor)
    {
        $preceptor->delete();
        return redirect()->route('preceptors.index')
            ->with('success', 'Preceptor eliminado correctamente.');
    }
}
