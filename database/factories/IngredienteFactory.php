<?php

namespace Database\Factories;

use App\Models\Ingrediente;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredienteFactory extends Factory
{
    protected $model = Ingrediente::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'unidad_medida' => $this->faker->randomElement(['gramos', 'mililitros', 'unidades']),
        ];
    }
}