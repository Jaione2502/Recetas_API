<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
    use HasFactory;
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