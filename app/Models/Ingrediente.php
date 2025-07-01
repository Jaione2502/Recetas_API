<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingrediente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'unidad_medida',
    ];

    public function recetas()
    {
        return $this->belongsToMany(Receta::class, 'linea_receta')
            ->withPivot('cantidad')
            ->withTimestamps();
    }

    public function inventario()
    {
        return $this->hasMany(Inventario::class);
    }
}