<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function recetas()
    {
        return $this->hasMany(Receta::class, 'usuario_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'usuario_id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'usuario_id');
    }

    public function inventario()
    {
        return $this->hasMany(Inventario::class, 'usuario_id');
    }
}
