<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Preceptor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Listado de usuarios (Admin)
    public function index()
    {
        if (Auth::user()->rol === "Admin") {
            $users = User::all();
            return view('users.index', compact('users'));
        } else {
            return view('layouts.no-autorizado');
        }
    }

    // Form para crear usuario (Admin)
    public function create()
    {
        if (Auth::user()->rol === "Admin") {
            return view('users.create');
        } else {
            return view('layouts.no-autorizado');
        }
    }

    // Guardar usuario nuevo (Admin)
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'rol'      => 'required|string|max:50',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'rol'      => $request->rol,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
    }

    // Form para editar usuario (Admin)
    public function edit(User $user)
    {
        if (Auth::user()->rol === "Admin") {
            return view('users.edit', compact('user'));
        } else {
            return view('layouts.no-autorizado');
        }
    }

    // Actualizar usuario (Admin)
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'rol'   => 'required|string|max:50',
        ]);

        $user->update($request->only('name', 'email', 'rol'));

        return redirect()->route('users.index')->with('success', 'Usuario actualizado');
    }

    // Eliminar usuario (Admin)
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado');
    }

    // Cambiar la contraseña de OTRO usuario (Admin)
    public function changeUserPasswordForm(User $user)
    {
        return view('users.change-user-password', compact('user'));
    }

    public function changeUserPassword(Request $request, User $user)
    {
        if (Auth::user()->rol === "Admin") {
            $request->validate([
                'password' => 'required|min:6|confirmed'
            ]);

            $user->update(['password' => Hash::make($request->password)]);

            return redirect()->route('users.index')->with('success', 'Contraseña actualizada');
        } else {
            return view('layouts.no-autorizado');
        }
    }

    // Cada usuario cambia su propia contraseña
    public function changeOwnPasswordForm()
    {
        return view('users.change-own-password');
    }

    public function changeOwnPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no coincide']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', '¡Tu contraseña ha sido cambiada!');
    }

    public function formVincularPersona($id)
    {
        $user = User::findOrFail($id);
        $preceptores = Preceptor::orderBy('apellido')->get();
        $docentes = Docente::orderBy('apellido')->get();
        // etc...

        return view('users.vincular_persona', compact('user', 'preceptores', 'docentes'));
    }

    public function guardarVinculacion(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:preceptor,docente,administrativo',
            'persona_id' => 'required|integer',
        ]);

        $user = User::findOrFail($id);

        // Limpiar vínculos anteriores
        $user->id_preceptor = null;
        $user->id_docente = null;
        $user->id_administrativo = null;

        // Asignar el nuevo vínculo
        switch ($request->tipo) {
            case 'preceptor':
                $user->id_preceptor = $request->persona_id;
                break;
            case 'docente':
                $user->id_docente = $request->persona_id;
                break;
            case 'administrativo':
                $user->id_administrativo = $request->persona_id;
                break;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Persona vinculada correctamente al usuario.');
    }
}
