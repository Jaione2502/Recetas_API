<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function recetas()
    {
        return $this->hasMany(Receta::class, 'categoria_id');
    }
}