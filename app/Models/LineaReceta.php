<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LineaReceta extends Model
{
    use HasFactory;
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