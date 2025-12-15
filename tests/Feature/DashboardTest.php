<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dueno_es_redirigido_al_dashboard_del_dueno()
    {
        $owner = User::factory()->create([
            'role' => 'owner'
        ]);

        $response = $this->actingAs($owner)->get('/dashboard');

        $response->assertRedirect(route('dashboard.owner'));
    }

    /** @test */
    public function usuario_es_redirigido_a_la_pantalla_de_ventas()
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect(route('ventas.create'));
    }
}
