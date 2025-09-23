<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    /** @use HasFactory<\Database\Factories\NotaFactory> */
    use HasFactory;
    protected $guarded = [];

    public function historialAcademico()
    {
        return $this->belongsTo(HistorialAcademico::class, 'id_historial_academico', 'id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia', 'id');
    }
    public function historial()
    {
        return $this->belongsTo(HistorialAcademico::class, 'id_historial_academico', 'id');
    }

}
