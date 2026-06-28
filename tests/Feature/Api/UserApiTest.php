<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_fetch_info()
    {
        $user = User::factory()->create([
            'email' => 'auth@example.com',
            'balance' => 5000,
        ]);

        // Acting as the authenticated user
        $response = $this->actingAs($user)->getJson('/api/v1/user/info');

        $response->assertStatus(200)
                 ->assertJsonPath('data.email', 'auth@example.com')
                 ->assertJsonPath('data.balance', 5000);
    }

    public function test_unauthenticated_user_cannot_fetch_info()
    {
        $response = $this->getJson('/api/v1/user/info');

        $response->assertStatus(403)
                 ->assertJsonStructure(['message']);
    }
}
