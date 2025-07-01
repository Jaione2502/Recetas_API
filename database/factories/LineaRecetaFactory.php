<?php

namespace Database\Factories;

use App\Models\LineaReceta;
use App\Models\Receta;
use App\Models\Ingrediente;
use Illuminate\Database\Eloquent\Factories\Factory;

class LineaRecetaFactory extends Factory
{
    protected $model = LineaReceta::class;

    public function definition()
    {
        return [
            'receta_id' => Receta::factory(),
            'ingrediente_id' => Ingrediente::factory(),
            'paso' => $this->faker->numberBetween(1, 10),
            'contenido' =>$this->faker->paragraph(),
            'cantidad' => $this->faker->randomFloat(2, 1, 500),
        ];
    }
}