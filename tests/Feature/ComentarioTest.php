<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Receta;
use App\Models\Comentario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ComentarioTest extends TestCase
{
    use RefreshDatabase;

  
    public function test_crear_comentario()
    {
        $usuario = Usuario::factory()->create();
        $receta = Receta::factory()->create();

        $response = $this->actingAs($usuario, 'sanctum')->postJson('/api/comentario', [
            'usuario_id' => $usuario->id,
            'receta_id' => $receta->id,
            'contenido' => 'Este es un comentario de prueba',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'usuario_id' => $usuario->id,
                     'receta_id' => $receta->id,
                     'contenido' => 'Este es un comentario de prueba',
                 ]);

        $this->assertDatabaseHas('comentarios', [
            'usuario_id' => $usuario->id,
            'receta_id' => $receta->id,
            'contenido' => 'Este es un comentario de prueba',
        ]);
    }

    
    public function test_modificar_comentario()
    {
        $usuario = Usuario::factory()->create();
        $comentario = Comentario::factory()->create([
            'contenido' => 'Comentario inicial',
            'usuario_id' => $usuario->id,
        ]);

        $response = $this->actingAs($usuario, 'sanctum')->putJson("/api/comentario/{$comentario->id}", [
            'contenido' => 'Comentario modificado correctamente',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $comentario->id,
                     'contenido' => 'Comentario modificado correctamente',
                 ]);

        $this->assertDatabaseHas('comentarios', [
            'id' => $comentario->id,
            'contenido' => 'Comentario modificado correctamente',
        ]);
    }


    public function test_eliminar_comentario()
    {
        $usuario = Usuario::factory()->create();
        $comentario = Comentario::factory()->create([
            'usuario_id' => $usuario->id,
        ]);

        $response = $this->actingAs($usuario, 'sanctum')->deleteJson("/api/comentario/{$comentario->id}");

     $response->assertStatus(200)
         ->assertJson([
             0 => 'message',
             1 => 'Comentario borrado correctamente',
             2 => 200,
         ]);

        $this->assertDatabaseMissing('comentarios', [
            'id' => $comentario->id,
        ]);
    }

 
    public function test_listar_comentario()
    {
        $usuario = Usuario::factory()->create();
        $comentario = Comentario::factory()->create([
            'usuario_id' => $usuario->id,
        ]);

        $response = $this->actingAs($usuario, 'sanctum')->getJson('/api/comentario');

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $comentario->id,
                     'contenido' => $comentario->contenido,
                 ]);
    }

   
    public function test_listar_comentario_ByID()
    {
        $usuario = Usuario::factory()->create();
        $comentario = Comentario::factory()->create([
            'usuario_id' => $usuario->id,
        ]);

        $response = $this->actingAs($usuario, 'sanctum')->getJson("/api/comentario/{$comentario->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $comentario->id,
                     'contenido' => $comentario->contenido,
                 ]);
    }
}
