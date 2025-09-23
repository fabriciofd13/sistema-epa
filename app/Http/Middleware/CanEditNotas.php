<?php

namespace App\Http\Middleware;

use App\Models\CursoDivision;
use App\Models\HistorialAcademico;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanEditNotas
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user->rol === 'Administrativo') {
            return $next($request); // Tiene acceso total
        }

        if ($user->rol === 'Preceptor') {
            // Obtenemos el historial y el curso
            $id_historial = $request->route('id_historial');
            $historial = HistorialAcademico::find($id_historial);

            if (!$historial) {
                abort(404, 'Historial no encontrado.');
            }

            $curso = CursoDivision::find($historial->id_curso);

            if (!$curso || $curso->id_preceptor !== $user->id_preceptor) {
                abort(403, 'No tenés permiso para acceder a este curso.');
            }

            return $next($request);
        }

        // Otros roles no tienen permiso
        abort(403, 'No tenés permiso para acceder a esta sección.');
    }
}
