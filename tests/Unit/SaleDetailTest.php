<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\User;

class SaleDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_sale_detail_belongs_to_sale_and_product_and_has_no_timestamps()
    {
        $user = User::factory()->create();

        $sale = Sale::create([
            'user_id' => $user->id,
            'subtotal' => 100,
            'iva' => 25,
            'total' => 125,
        ]);

        $product = Product::create([
            'name' => 'Test Product',
            'stock' => 5,
            'price' => 10,
        ]);

        $detail = SaleDetail::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 10,
        ]);

        $this->assertInstanceOf(Sale::class, $detail->sale);
        $this->assertEquals($sale->id, $detail->sale->id);

        $this->assertInstanceOf(Product::class, $detail->product);
        $this->assertEquals($product->id, $detail->product->id);

        // SaleDetail::$timestamps is false, so created_at/updated_at should not be set by Eloquent
        $this->assertFalse($detail->timestamps);
        $this->assertArrayNotHasKey('created_at', $detail->getAttributes());
        $this->assertArrayNotHasKey('updated_at', $detail->getAttributes());
    }
}
