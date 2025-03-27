<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use App\Http\Requests\StoreLocalidadRequest;
use App\Http\Requests\UpdateLocalidadRequest;

class LocalidadController extends Controller
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
    public function store(StoreLocalidadRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Localidad $localidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Localidad $localidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocalidadRequest $request, Localidad $localidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Localidad $localidad)
    {
        //
    }
}
