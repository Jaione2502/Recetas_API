<?php

namespace Database\Factories;

use App\Models\Inventario;
use App\Models\Usuario;
use App\Models\Ingrediente;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventarioFactory extends Factory
{
    protected $model = Inventario::class;

    public function definition()
    {
        return [
            'usuario_id' => Usuario::factory(),
            'ingrediente_id' => Ingrediente::factory(),
            'cantidad' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}