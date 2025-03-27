<?php

namespace App\Http\Controllers;

use App\Models\Barrio;
use App\Http\Requests\StoreBarrioRequest;
use App\Http\Requests\UpdateBarrioRequest;

class BarrioController extends Controller
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
    public function store(StoreBarrioRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Barrio $barrio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barrio $barrio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarrioRequest $request, Barrio $barrio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barrio $barrio)
    {
        //
    }
}
