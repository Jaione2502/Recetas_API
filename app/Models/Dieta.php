<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dieta extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function recetas()
    {
        return $this->belongsToMany(Receta::class, 'dieta_receta');
    }
}