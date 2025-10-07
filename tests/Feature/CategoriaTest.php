<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Categoria;
use App\Models\Usuario;
use Tests\TestCase;

class CategoriaTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_categoria()
    {
        $categoria = Categoria::factory()->create([
            'nombre' => 'Prueba test crear categoria',
            'descripcion' => 'Prueba descripcion test categoria',
        ]);

        $this->assertDatabaseHas('categorias', [
            'nombre' => 'Prueba test crear categoria',
            'descripcion' => 'Prueba descripcion test categoria',
        ]);
    }

 

     public function test_listar_categorias()
    {
        $usuario = Usuario::factory()->create();

        Categoria::factory()->count(3)->create();

        $response = $this->actingAs($usuario, 'sanctum')
                        ->getJson('/api/categoria');

        $response->assertStatus(200)
                ->assertJsonCount(3);
    }

      public function test_listar_categoria_ByID()
    {
        $usuario = Usuario::factory()->create();
        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($usuario, 'sanctum')
                        ->getJson("/api/categoria/{$categoria->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'nombre' => $categoria->nombre,
                    'descripcion' => $categoria->descripcion,
                ]);
    }


    public function test_modificar_categoria()
    {
       
        $usuario = Usuario::factory()->create();
        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($usuario, 'sanctum')
                         ->putJson("/api/categoria/{$categoria->id}", [
                             'nombre' => 'Nombre Actualizado',
                             'descripcion' => 'Descripcion Actualizada',
                         ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Categoría actualizada correctamente',
                     'categoria' => [
                         'nombre' => 'Nombre Actualizado',
                         'descripcion' => 'Descripcion Actualizada',
                     ]
                 ]);

        $this->assertDatabaseHas('categorias', [
            'id' => $categoria->id,
            'nombre' => 'Nombre Actualizado',
            'descripcion' => 'Descripcion Actualizada',
        ]);
    }

    public function test_eliminar_categoria()
    {
       
        $usuario = Usuario::factory()->create();
        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($usuario, 'sanctum')
                         ->deleteJson("/api/categoria/{$categoria->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     1 => 'Categoría borrada correctamente'
                 ]);

        $this->assertDatabaseMissing('categorias', [
            'id' => $categoria->id,
        ]);
    }



}
