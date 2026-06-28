<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfigAdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_fetch_config()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->getJson('/api/v1/admin/config/fetch');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_admin_can_save_config()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->postJson('/api/v1/admin/config/save', [
            'app_name' => 'Xboard Test Engine',
            'app_url' => 'https://test.example.com',
            'app_description' => 'Automated testing environment'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('v2_settings', [
            'key' => 'app_name',
            'value' => 'Xboard Test Engine'
        ]);
    }
}
