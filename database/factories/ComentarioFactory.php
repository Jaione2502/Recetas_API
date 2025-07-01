<?php

namespace Database\Factories;

use App\Models\Comentario;
use App\Models\Usuario;
use App\Models\Receta;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComentarioFactory extends Factory
{
    protected $model = Comentario::class;

    public function definition()
    {
        return [
            'usuario_id' => Usuario::factory(),
            'receta_id' => Receta::factory(),
            'contenido' => $this->faker->sentence(),
        ];
    }
}