<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartAndTicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_puede_agregar_producto_al_carrito()
    {
        $user = User::factory()->create();

        $product = Product::create([
            'name' => 'Pan dulce',
            'price' => 10,
            'stock' => 20
        ]);

        $this->actingAs($user);

        $response = $this->post('/carrito/agregar', [
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $response->assertRedirect('/ventas');
        $this->assertEquals(2, session('cart')[$product->id]['quantity']);
    }

    /** @test */
    public function se_calcula_correctamente_el_iva_y_total()
    {
        $user = User::factory()->create();

        $product = Product::create([
            'name' => 'Concha',
            'price' => 10,
            'stock' => 20
        ]);

        $this->actingAs($user);

        $this->post('/carrito/agregar', [
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $this->post('/ventas/confirmar');

        $sale = Sale::first();

        $this->assertNotNull($sale);
        $this->assertEquals(20, $sale->subtotal);
        $this->assertEquals(3.2, $sale->iva);
        $this->assertEquals(23.2, $sale->total);
    }

    /** @test */
    public function se_genera_el_ticket_despues_de_confirmar_venta()
    {
        $user = User::factory()->create();

        $product = Product::create([
            'name' => 'Bolillo',
            'price' => 5,
            'stock' => 50
        ]);

        $this->actingAs($user);

        $this->post('/carrito/agregar', [
            'product_id' => $product->id,
            'quantity' => 4
        ]);

        $this->post('/ventas/confirmar');

        $sale = Sale::first();

        $response = $this->get('/ticket/' . $sale->id);

        $response->assertStatus(200);
        $response->assertSee('Ticket de venta');
        $response->assertSee('IVA');
        $response->assertSee('Total');
    }
}
