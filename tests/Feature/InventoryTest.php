<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_autenticado_puede_ver_el_inventario()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/inventario');

        $response->assertStatus(200);
        $response->assertSee('Inventario');
    }

    /** @test */
    public function usuario_autenticado_puede_agregar_productos()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/inventario', [
            'name' => 'Pan dulce',
            'stock' => 50,
            'price' => 10
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('products', [
            'name' => 'Pan dulce',
            'stock' => 50,
            'price' => 10
        ]);
    }

    /** @test */
    public function usuario_no_autenticado_no_puede_ver_el_inventario()
    {
        $response = $this->get('/inventario');

        $response->assertRedirect('/login');
    }
}
