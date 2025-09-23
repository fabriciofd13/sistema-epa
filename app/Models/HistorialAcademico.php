<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialAcademico extends Model
{
    /** @use HasFactory<\Database\Factories\HistorialAcademicoFactory> */
    use HasFactory;


    protected $guarded = [];
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno', 'id');
    }

    public function curso()
    {
        return $this->belongsTo(CursoDivision::class, 'id_curso', 'id');
    }

    public function notas()
    {
        return $this->hasMany(Nota::class, 'id_historial_academico', 'id');
    }
    
}
