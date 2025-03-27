<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use App\Http\Requests\StoreNovedadRequest;
use App\Http\Requests\UpdateNovedadRequest;

class NovedadController extends Controller
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
    public function store(StoreNovedadRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Novedad $novedad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Novedad $novedad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNovedadRequest $request, Novedad $novedad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Novedad $novedad)
    {
        //
    }
}
