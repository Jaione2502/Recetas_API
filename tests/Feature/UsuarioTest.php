<?php

namespace Tests\Feature\Auth;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UsuarioTest extends TestCase
{
    use RefreshDatabase;

  
    public function test_pueden_crear_cuenta()
    {

     $admin = Usuario::factory()->create([
            'password' => bcrypt('password123') // importante que esté hasheada
        ]);

        // Autenticamos al admin con Sanctum
        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/usuario', [
            'name' => 'Prueba Test',
            'email' => 'pruebatest@example.com',
            'password' => 'password123',
        ]);

        // Aserciones
        $response->assertStatus(201)
                 ->assertJsonStructure(['id']);

        $this->assertDatabaseHas('usuarios', [
            'email' => 'pruebatest@example.com'
        ]);


    }

  
    public function test_pueden_loguearse_con_credenciales_validas()
    {
        $usuario = Usuario::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $usuario->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'access_token',
                     'token_type',
                 ]);
    }

  
    public function test_no_pueden_loguearse_con_contrasena_invalida()
    {
        $usuario = Usuario::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $usuario->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Credenciales inválidas']);
    }

 
    public function test_hacer_logout()
    {
        $usuario = Usuario::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $token = $usuario->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Sesión cerrada correctamente']);
    }

  
    public function test_actualizar_usuario()
    {
         $admin = Usuario::factory()->create([
        'password' => bcrypt('password123')
        ]);

       
        $usuario = Usuario::factory()->create();

        
        $response = $this->actingAs($admin, 'sanctum')
                        ->putJson("/api/usuario/{$usuario->id}", [
                            'name' => 'Nuevo Nombre',
                            'email' => 'pruebatest@example.com',
                        ]);

       
        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Usuario actualizado correctamente',
                    'usuario' => [
                        'name' => 'Nuevo Nombre',
                        'email' => 'pruebatest@example.com',
                    ]
                ]);

        $this->assertDatabaseHas('usuarios', [
            'id' => $usuario->id,
            'name' => 'Nuevo Nombre',
            'email' => 'pruebatest@example.com',
        ]);
    }

   
    public function test_eliminar_usuario()
    {
       $admin = Usuario::factory()->create([
        'password' => bcrypt('password123')
        ]);

   
    $usuario = Usuario::factory()->create();

   
    $response = $this->actingAs($admin, 'sanctum')
                     ->deleteJson("/api/usuario/{$usuario->id}");

   $response->assertStatus(200)
         ->assertJson([
             1 => 'Usuario borrado correctamente'
         ]);

    $this->assertDatabaseMissing('usuarios', [
        'id' => $usuario->id
    ]);
    }
}
