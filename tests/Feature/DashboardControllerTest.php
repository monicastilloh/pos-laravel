<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Sale;
use App\Models\Product;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_owner_shows_totals_and_low_stock()
    {
        $user = User::factory()->create(['role' => 'owner']);

        Sale::create([
            'user_id' => $user->id,
            'subtotal' => 80,
            'iva' => 20,
            'total' => 100,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Sale::create([
            'user_id' => $user->id,
            'subtotal' => 40,
            'iva' => 10,
            'total' => 50,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Sale::create([
            'user_id' => $user->id,
            'subtotal' => 20,
            'iva' => 5,
            'total' => 25,
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay(),
        ]);

        // Products: one low stock, one sufficient stock
        Product::create(['name' => 'LowStock', 'stock' => 3, 'price' => 10]);
        Product::create(['name' => 'HighStock', 'stock' => 10, 'price' => 5]);

        $response = $this->actingAs($user)->get(route('dashboard.owner'));

        $expectedTotalSales = Sale::count();
        $expectedTotalIncome = Sale::sum('total');
        $expectedTodaySales = Sale::whereDate('created_at', today())->count();
        $expectedTodayIncome = Sale::whereDate('created_at', today())->sum('total');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertViewHas('totalSales', $expectedTotalSales);
        $response->assertViewHas('totalIncome', $expectedTotalIncome);
        $response->assertViewHas('todaySales', $expectedTodaySales);
        $response->assertViewHas('todayIncome', $expectedTodayIncome);
        $response->assertViewHas('lowStockProducts', function ($products) {
            return $products->contains('name', 'LowStock') && $products->firstWhere('name', 'LowStock')->stock <= 5;
        });
    }
}
