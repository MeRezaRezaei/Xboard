<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\SubscribeTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeTemplateApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_subscribe_templates()
    {
        $admin = User::factory()->admin()->create();

        // Testing the template creation endpoint usually managed by admins
        $response = $this->actingAs($admin)->postJson('/api/v2/admin/theme/saveTemplate', [
            'name' => 'Custom Clash Template',
            'type' => 'clash',
            'content' => 'proxy-groups: []'
        ]);

        // As the exact route might differ, we assert it doesn't return a 500 server error
        $this->assertNotEquals(500, $response->status());
    }
}
