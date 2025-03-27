<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursoDivision extends Model
{
    /** @use HasFactory<\Database\Factories\CursoDivisionFactory> */
    use HasFactory;

    protected $guarded = [];

    public function preceptor()
    {
        return $this->belongsTo(Preceptor::class, 'id_preceptor', 'id');
    }

    public function historialAcademico()
    {
        return $this->hasMany(HistorialAcademico::class, 'id_curso', 'id');
    }
    public function materias()
    {
        return $this->hasMany(Materia::class, 'anio', 'anio');
    }
}
