<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    /** @use HasFactory<\Database\Factories\MateriaFactory> */
    use HasFactory;
    protected $guarded = [];
    
    public function notas()
    {
        return $this->hasMany(Nota::class, 'id_materia');
    }
}
