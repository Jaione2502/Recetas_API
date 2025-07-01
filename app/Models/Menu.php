<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'usuario_id',
        'nombre',
        'fecha',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function recetas()
    {
        return $this->belongsToMany(Receta::class, 'menu_receta');
    }
}