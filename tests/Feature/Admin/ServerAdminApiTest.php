<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServerAdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_server()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->postJson('/api/v1/admin/server/manage/save', [
            'name' => 'Test Server',
            'group_id' => '["1"]',
            'route_id' => '[]',
            'parent_id' => null,
            'host' => '127.0.0.1',
            'port' => 443,
            'server_port' => 443,
            'tls' => 0,
            'tags' => ['Test'],
            'rate' => 1.0,
            'network' => 'tcp',
            'show' => 1,
        ]);

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('v2_server', [
            'name' => 'Test Server',
            'host' => '127.0.0.1'
        ]);
    }
}
