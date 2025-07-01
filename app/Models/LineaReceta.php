<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineaReceta extends Model
{
    protected $table = 'linea_receta';

    protected $fillable = [
        'receta_id',
        'ingrediente_id',
        'paso',
        'contenido',
        'cantidad',
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class);
    }
}