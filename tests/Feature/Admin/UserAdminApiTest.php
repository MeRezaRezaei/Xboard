<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_fetch_users()
    {
        $admin = User::factory()->admin()->create();
        User::factory()->create(['email' => 'client@example.com']);

        $response = $this->actingAs($admin)->getJson('/api/v1/admin/user/fetch');

        $response->assertStatus(200)
                 ->assertJsonFragment(['email' => 'client@example.com']);
    }

    public function test_non_admin_cannot_fetch_users()
    {
        $user = User::factory()->create([
            'is_admin' => 0,
            'is_staff' => 0,
        ]);

        $response = $this->actingAs($user)->getJson('/api/v1/admin/user/fetch');

        $response->assertStatus(403);
    }
}
