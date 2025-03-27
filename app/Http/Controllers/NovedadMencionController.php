<?php

namespace App\Http\Controllers;

use App\Models\NovedadMencion;
use App\Http\Requests\StoreNovedadMencionRequest;
use App\Http\Requests\UpdateNovedadMencionRequest;

class NovedadMencionController extends Controller
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
    public function store(StoreNovedadMencionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NovedadMencion $novedadMencion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NovedadMencion $novedadMencion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNovedadMencionRequest $request, NovedadMencion $novedadMencion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NovedadMencion $novedadMencion)
    {
        //
    }
}
