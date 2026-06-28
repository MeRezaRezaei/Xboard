<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Notice;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoticeAdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_notice()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->postJson($this->getAdminUri('notice/save'), [
            'title' => 'New Feature Announcement',
            'content' => 'We have added a new feature to the platform.',
            'show' => 1,
            'tags' => ['news', 'features']
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('v2_notice', [
            'title' => 'New Feature Announcement',
        ]);
    }

    public function test_admin_can_update_notice()
    {
        $admin = User::factory()->admin()->create();
        $notice = Notice::factory()->create(['title' => 'Old Title']);

        $response = $this->actingAs($admin)->postJson($this->getAdminUri('notice/save'), [
            'id' => $notice->id,
            'title' => 'Updated Title',
            'content' => 'Updated content here.',
            'show' => 1,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('v2_notice', [
            'id' => $notice->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_admin_can_delete_notice()
    {
        $admin = User::factory()->admin()->create();
        $notice = Notice::factory()->create();

        $response = $this->actingAs($admin)->postJson($this->getAdminUri('notice/drop'), [
            'id' => $notice->id,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('v2_notice', [
            'id' => $notice->id,
        ]);
    }
}
