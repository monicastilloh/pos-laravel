<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dueno_puede_ver_el_historial_de_ventas()
    {
        $owner = User::factory()->create([
            'role' => 'owner'
        ]);

        $response = $this->actingAs($owner)->get('/ventas');

        $response->assertStatus(200);
        $response->assertSee('Historial de Ventas');
    }

    /** @test */
    public function historial_muestra_ventas_registradas()
    {
        $owner = User::factory()->create([
            'role' => 'owner'
        ]);

        Sale::create([
            'user_id' => $owner->id,
            'subtotal' => 100,
            'iva' => 16,
            'total' => 116
        ]);

        $response = $this->actingAs($owner)->get('/ventas');

        $response->assertStatus(200);
        $response->assertSee('$116.00');
    }

    /** @test */
    public function usuario_no_autenticado_no_puede_ver_el_historial()
    {
        $response = $this->get('/ventas');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function se_puede_acceder_al_ticket_desde_el_historial()
    {
        $owner = User::factory()->create([
            'role' => 'owner'
        ]);

        $sale = Sale::create([
            'user_id' => $owner->id,
            'subtotal' => 50,
            'iva' => 8,
            'total' => 58
        ]);

        $response = $this->actingAs($owner)
            ->get('/ticket/' . $sale->id);

        $response->assertStatus(200);
        $response->assertSee('Ticket');
    }
}
