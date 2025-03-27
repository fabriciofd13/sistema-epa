<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preceptor extends Model
{
    /** @use HasFactory<\Database\Factories\PreceptorFactory> */
    use HasFactory;
    protected $guarded = [];
    public function cursos()
    {
        return $this->hasMany(CursoDivision::class, 'id_preceptor','id');
    }
}
