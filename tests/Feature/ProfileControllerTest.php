<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_displays_profile_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
        $response->assertViewHas('user', function ($viewUser) use ($user) {
            return $viewUser->id === $user->id;
        });
    }

    public function test_update_resets_email_verified_when_email_changed()
    {
        $user = User::factory()->create([
            'name' => 'Original',
            'email' => 'original@example.com',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'Updated',
            'email' => 'updated@example.com',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'profile-updated');

        $user->refresh();

        $this->assertEquals('Updated', $user->name);
        $this->assertEquals('updated@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_destroy_deletes_account_with_correct_password()
    {
        $password = 'secret123';
        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        $response = $this->actingAs($user)->from(route('profile.edit'))->delete(route('profile.destroy'), [
            'password' => $password,
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertGuest();
    }

    public function test_update_keeps_email_verified_when_email_not_changed()
    {
        $user = User::factory()->create([
            'name' => 'Original',
            'email' => 'original@example.com',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'Original Updated',
            'email' => 'original@example.com',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'profile-updated');

        $user->refresh();

        $this->assertEquals('Original Updated', $user->name);
        $this->assertEquals('original@example.com', $user->email);
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_update_returns_validation_errors_on_invalid_input()
    {
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
        ]);

        $response = $this->actingAs($user)->from(route('profile.edit'))->patch(route('profile.update'), [
            'name' => '', // required
            'email' => 'not-an-email',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHasErrors(['name', 'email']);

        $user->refresh();
        $this->assertEquals('User', $user->name);
        $this->assertEquals('user@example.com', $user->email);
    }
}
