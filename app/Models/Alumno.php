<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumno extends Model
{
    /** @use HasFactory<\Database\Factories\AlumnoFactory> */
    /* use HasFactory; */
    use HasFactory, SoftDeletes;


    protected $guarded = [];

    protected $dates = ['deleted_at'];
    public function cursoDivision()
    {
        return $this->belongsTo(CursoDivision::class, 'id_curso', 'id');
    }

    // ❌ ERROR: Estás relacionando directamente a `Nota`, pero ahora depende de `HistorialAcademico`
    // ❌ Esto no es necesario ya que `Nota` no tiene `id_alumno`
    /* public function notas()
    {
        return $this->hasMany(Nota::class, 'id_alumno', 'id');
    } */

    // ✅ Corrección: Relacionamos a través de `HistorialAcademico`
    public function historialAcademico()
    {
        return $this->hasMany(HistorialAcademico::class, 'id_alumno', 'id');
    }

    // ✅ Para acceder a todas las notas del alumno, accedemos a través del historial académico
    public function notas()
    {
        return $this->hasManyThrough(Nota::class, HistorialAcademico::class, 'id_alumno', 'id_historial_academico', 'id', 'id');
    }
    public function historiales()
    {
        return $this->hasMany(HistorialAcademico::class, 'id_alumno', 'id');
    }
}
