<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;

class SaleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_displays_products_and_cart()
    {
        $user = User::factory()->create();

        $p1 = Product::create(['name' => 'A', 'stock' => 5, 'price' => 10]);
        $p2 = Product::create(['name' => 'B', 'stock' => 3, 'price' => 20]);
        $response = $this->actingAs($user)->get(route('ventas.create'));

        $response->assertStatus(200);
        $response->assertViewIs('sales.create');
        $response->assertViewHas('products');
    }
    public function test_checkout_creates_sale_details_and_decrements_stock()
    {
        $user = User::factory()->create();

        $product = Product::create(['name' => 'CheckoutProd', 'stock' => 10, 'price' => 7.5]);

        $response = $this->actingAs($user)->post('/ventas/confirmar', [
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $response->assertRedirect(route('ventas.create'));

        $sale = Sale::first();
        $this->assertNotNull($sale);

        $subtotal = $product->price * 3;
        $iva = $subtotal * 0.16;
        $expectedTotal = $subtotal + $iva;

        $this->assertEquals(round($expectedTotal, 2), round($sale->total, 2));

        $this->assertDatabaseHas('sale_details', [
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'price' => $product->price,
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 7,
        ]);

        $response->assertSessionHas('ticket_id', $sale->id);
    }

    public function test_ticket_view_shows_sale()
    {
        $user = User::factory()->create();

        $product = Product::create(['name' => 'T', 'stock' => 5, 'price' => 2]);
        // create a sale manually
        $sale = Sale::create([
            'user_id' => $user->id,
            'subtotal' => 10,
            'iva' => 1.6,
            'total' => 11.6,
        ]);

        $response = $this->actingAs($user)->get(route('ticket.show', $sale->id));

        $response->assertStatus(200);
        $response->assertViewIs('sales.ticket');
        $response->assertViewHas('sale');
    }
}
