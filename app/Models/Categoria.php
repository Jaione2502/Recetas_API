<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function recetas()
    {
        return $this->hasMany(Receta::class, 'categoria_id');
    }
}