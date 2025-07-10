<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dieta extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

  
    public function recetas()
    {
        return $this->hasMany(Receta::class, 'dieta_id');
    }
    
}