<?php

namespace Tests\Feature\Client;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_subscribe_endpoint_with_token()
    {
        $plan = Plan::factory()->create();
        $user = User::factory()->create([
            'plan_id' => $plan->id,
            'token' => 'SECRET_TOKEN_123',
            'expired_at' => time() + 86400,
            'banned' => 0
        ]);

        $response = $this->get('/api/v1/client/subscribe?token=' . $user->token);

        $response->assertStatus(200);
    }

    public function test_subscribe_endpoint_fails_with_invalid_token()
    {
        $response = $this->get('/api/v1/client/subscribe?token=INVALID_TOKEN_999');

        $this->assertTrue(in_array($response->status(), [401, 403, 404, 500]));
    }
}
