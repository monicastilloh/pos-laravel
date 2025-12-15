<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function cajero_no_puede_ver_dashboard_del_dueno()
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        
        $response = $this->actingAs($user)->get('/dashboard/owner');

        $response->assertStatus(403);
    }
}
