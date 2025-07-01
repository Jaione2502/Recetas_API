<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition()
    {
        return [
            'usuario_id' => Usuario::factory(),
            'nombre' => $this->faker->word(),
            'fecha' => $this->faker->date(),
        ];
    }
}