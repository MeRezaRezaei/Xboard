<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoticeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_fetch_notices()
    {
        $user = User::factory()->create();
        
        $notice = Notice::factory()->create([
            'title' => 'System Maintenance Scheduled',
            'show' => 1
        ]);

        Notice::factory()->create([
            'title' => 'Hidden Secret Notice',
            'show' => 0
        ]);

        $response = $this->actingAs($user)->getJson('/api/v1/user/notice/fetch');

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'System Maintenance Scheduled'])
                 ->assertJsonMissing(['title' => 'Hidden Secret Notice']);
    }
}
