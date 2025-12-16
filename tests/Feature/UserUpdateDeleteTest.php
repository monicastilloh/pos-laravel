<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUpdateDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dueno_puede_actualizar_un_cajero()
    {
        $owner = User::factory()->create(['role' => 'owner']);

        $cajero = User::factory()->create([
            'role' => 'user',
            'name' => 'Cajero 1',
        ]);

        $response = $this->actingAs($owner)->put(
            route('usuarios.update', $cajero),
            [
                'name' => 'Cajero Editado',
                'email' => $cajero->email,
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]
        );

        $response->assertRedirect(route('usuarios.index'));

        $this->assertDatabaseHas('users', [
            'id' => $cajero->id,
            'name' => 'Cajero Editado',
        ]);
    }

    /** @test */
    public function dueno_puede_eliminar_un_cajero()
    {
        $owner = User::factory()->create(['role' => 'owner']);

        $cajero = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($owner)->delete(
            route('usuarios.destroy', $cajero)
        );

        $response->assertRedirect(route('usuarios.index'));

        $this->assertDatabaseMissing('users', [
            'id' => $cajero->id,
        ]);
    }

    /** @test */
    public function usuario_normal_no_puede_editar_ni_eliminar_cajeros()
    {
        $user = User::factory()->create(['role' => 'user']);
        $cajero = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->put(route('usuarios.update', $cajero), [
                'name' => 'Hack',
                'email' => $cajero->email,
            ])
            ->assertStatus(403);

        $this->actingAs($user)
            ->delete(route('usuarios.destroy', $cajero))
            ->assertStatus(403);
    }
}
