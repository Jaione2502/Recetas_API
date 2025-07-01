<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;
    protected $fillable = [
        'usuario_id',
        'receta_id',
        'contenido',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }
}