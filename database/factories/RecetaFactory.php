<?php

namespace Database\Factories;

use App\Models\Receta;
use App\Models\Usuario;
use App\Models\Categoria;
use App\Models\Dieta;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecetaFactory extends Factory
{
    protected $model = Receta::class;

    public function definition()
    {
        return [
            'usuario_id' => Usuario::factory(),
            'categoria_id' => Categoria::factory(),
            'dieta_id' => Dieta::factory(),
            'titulo' => $this->faker->sentence(3),
            'descripcion' => $this->faker->paragraph(),
            'instrucciones' => $this->faker->paragraphs(3, true),
            'tiempo_preparacion' => $this->faker->numberBetween(10, 120),
            'porciones' => $this->faker->numberBetween(1, 10),
        ];
    }
}