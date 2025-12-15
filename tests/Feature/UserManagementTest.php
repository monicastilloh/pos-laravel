<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dueno_puede_crear_cajeros()
{
    $owner = User::factory()->create(['role' => 'owner']);

    $response = $this->actingAs($owner)->post('/usuarios', [
        'name' => 'Cajero 1',
        'email' => 'cajero@test.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response->assertRedirect(route('usuarios.index'));

    $this->assertDatabaseHas('users', [
        'email' => 'cajero@test.com',
        'role' => 'user',
    ]);
}


    /** @test */
    public function usuario_normal_no_puede_crear_cajeros()
    {
        $user = User::factory()->create([
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->post('/usuarios', [
            'name' => 'Hack',
            'email' => 'hack@test.com',
            'password' => '123456',
        ]);

        $response->assertStatus(403);
    }
}
