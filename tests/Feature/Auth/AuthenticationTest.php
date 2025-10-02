<?php

namespace Tests\Feature\Auth;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function users_can_authenticate_with_valid_credentials()
    {
        // Creamos un usuario con password hasheado
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

    #[Test]
    public function users_cannot_authenticate_with_invalid_password()
    {
        $usuario = Usuario::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $usuario->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Credenciales inválidas']);
    }

    #[Test]
    public function users_can_logout()
    {
        $usuario = Usuario::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        // Creamos token de prueba
        $token = $usuario->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
                         ->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Sesión cerrada correctamente']);
    }
}
