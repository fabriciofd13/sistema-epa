<?php

namespace App\Http\Controllers;

use App\Models\DocenteMateriaCurso;
use App\Http\Requests\StoreDocenteMateriaCursoRequest;
use App\Http\Requests\UpdateDocenteMateriaCursoRequest;

class DocenteMateriaCursoController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocenteMateriaCursoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DocenteMateriaCurso $docenteMateriaCurso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocenteMateriaCurso $docenteMateriaCurso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocenteMateriaCursoRequest $request, DocenteMateriaCurso $docenteMateriaCurso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocenteMateriaCurso $docenteMateriaCurso)
    {
        //
    }
}
