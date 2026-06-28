<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Knowledge;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KnowledgeAdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_knowledge_article()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->postJson($this->getAdminUri('knowledge/save'), [
            'language' => 'en-US',
            'category' => 'General',
            'title' => 'New Knowledge Base Article',
            'body' => 'This is the content of the article.',
            'show' => 1,
            'sort' => 10,
        ]);

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('v2_knowledge', [
            'title' => 'New Knowledge Base Article',
        ]);
    }
}
