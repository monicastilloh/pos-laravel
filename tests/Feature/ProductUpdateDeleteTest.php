<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductUpdateDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dueno_puede_actualizar_un_producto()
    {
        $owner = User::factory()->create(['role' => 'owner']);

        $product = Product::create([
            'name' => 'Pan',
            'price' => 10,
            'stock' => 20,
        ]);

        $response = $this->actingAs($owner)->put(
            route('inventario.update', $product),
            [
                'name' => 'Pan dulce',
                'price' => 12,
                'stock' => 30,
            ]
        );

        $response->assertRedirect(route('inventario'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Pan dulce',
            'price' => 12,
            'stock' => 30,
        ]);
    }

    /** @test */
    public function dueno_puede_eliminar_un_producto()
    {
        $owner = User::factory()->create(['role' => 'owner']);

        $product = Product::create([
            'name' => 'Concha',
            'price' => 8,
            'stock' => 15,
        ]);

        $response = $this->actingAs($owner)->delete(
            route('inventario.destroy', $product)
        );

        $response->assertRedirect(route('inventario'));

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    /** @test */
    public function usuario_normal_no_puede_editar_ni_eliminar_productos()
    {
        $user = User::factory()->create(['role' => 'user']);

        $product = Product::create([
            'name' => 'Bolillo',
            'price' => 5,
            'stock' => 50,
        ]);

        $this->actingAs($user)
            ->put(route('inventario.update', $product), [
                'name' => 'Hack',
                'price' => 1,
                'stock' => 1,
            ])
            ->assertStatus(403);

        $this->actingAs($user)
            ->delete(route('inventario.destroy', $product))
            ->assertStatus(403);
    }
}
