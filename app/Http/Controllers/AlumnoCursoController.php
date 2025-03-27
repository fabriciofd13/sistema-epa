<?php

namespace App\Http\Controllers;

use App\Models\AlumnoCurso;
use App\Http\Requests\StoreAlumnoCursoRequest;
use App\Http\Requests\UpdateAlumnoCursoRequest;

class AlumnoCursoController extends Controller
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
    public function store(StoreAlumnoCursoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AlumnoCurso $alumnoCurso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlumnoCurso $alumnoCurso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlumnoCursoRequest $request, AlumnoCurso $alumnoCurso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlumnoCurso $alumnoCurso)
    {
        //
    }
}
