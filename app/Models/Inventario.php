<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';

    protected $fillable = [
        'usuario_id',
        'ingrediente_id',
        'cantidad',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class);
    }
}