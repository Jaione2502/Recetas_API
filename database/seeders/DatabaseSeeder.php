<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Categoria;
use App\Models\Ingrediente;
use App\Models\Dieta;
use App\Models\Receta;
use App\Models\Comentario;
use App\Models\Menu;
use App\Models\LineaReceta;
use App\Models\Inventario;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Usuarios
        Usuario::factory()->count(10)->create();

        // Categorias
        Categoria::factory()->count(5)->create();

        // Ingredientes
        Ingrediente::factory()->count(50)->create();

        // Dietas
        Dieta::factory()->count(3)->create();

        // Recetas
        Receta::factory()->count(30)->create();

        // Comentarios
        Comentario::factory()->count(50)->create();

        // Menus
        Menu::factory()->count(10)->create();

        // Línea receta
        LineaReceta::factory()->count(50)->create();

        // Inventario
        Inventario::factory()->count(20)->create();
    }
}