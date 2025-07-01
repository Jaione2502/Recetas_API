<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receta extends Model
{
    use HasFactory;
   protected $fillable = [
        'usuario_id',
        'categoria_id',
        'titulo',
        'descripcion',
        'instrucciones',
        'tiempo_preparacion',
        'porciones',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'linea_receta')
            ->withPivot('cantidad')
            ->withTimestamps();
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_receta');
    }

    public function dietas()
    {
        return $this->belongsToMany(Dieta::class, 'dieta_receta');
    }
}
