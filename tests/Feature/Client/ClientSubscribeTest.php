<?php

namespace Tests\Feature\Client;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plan;
use App\Models\Server;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientSubscribeTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_subscribe_returns_clash_config_based_on_user_agent()
    {
        $plan = Plan::factory()->create();
        $user = User::factory()->create([
            'plan_id' => $plan->id, 
            'token' => 'CLASH_TEST_TOKEN',
            'expired_at' => time() + 86400,
            'banned' => 0
        ]);

        Server::factory()->create([
            'group_ids' => [1],
            'show' => 1
        ]);

        // Simulating a request from a Clash client
        $response = $this->withHeaders([
            'User-Agent' => 'ClashforWindows/0.19.0'
        ])->get('/api/v1/client/subscribe?token=' . $user->token);

        $response->assertStatus(200);
        
        // Clash configs are YAML, they should contain proxies definition
        $this->assertStringContainsString('proxies:', $response->getContent());
        $this->assertStringContainsString('proxy-groups:', $response->getContent());
    }

    public function test_client_subscribe_returns_base64_for_generic_v2ray()
    {
        $plan = Plan::factory()->create();
        $user = User::factory()->create([
            'plan_id' => $plan->id, 
            'token' => 'V2RAY_TEST_TOKEN',
            'expired_at' => time() + 86400,
            'banned' => 0
        ]);

        // Simulating a generic v2rayN client
        $response = $this->withHeaders([
            'User-Agent' => 'v2rayN/5.23'
        ])->get('/api/v1/client/subscribe?token=' . $user->token);

        $response->assertStatus(200);
        
        $content = $response->getContent();
        // Check if the response is a valid base64 encoded string
        $this->assertEquals(base64_encode(base64_decode($content, true)), $content);
    }
    
    public function test_client_subscribe_applies_flag_override()
    {
        $plan = Plan::factory()->create();
        $user = User::factory()->create([
            'plan_id' => $plan->id, 
            'token' => 'FLAG_TEST_TOKEN',
            'expired_at' => time() + 86400,
            'banned' => 0
        ]);

        // Sending a generic User-Agent but explicitly requesting shadowrocket format
        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0'
        ])->get('/api/v1/client/subscribe?token=' . $user->token . '&flag=shadowrocket');

        $response->assertStatus(200);
        
        // Shadowrocket configs should contain specific URL schemes or base64 structures
        $this->assertNotEmpty($response->getContent());
    }
}
