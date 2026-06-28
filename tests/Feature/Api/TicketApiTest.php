<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_ticket()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/v1/user/ticket/save', [
            'subject' => 'Help with connection',
            'level' => 1,
            'message' => 'I cannot connect to the server.'
        ]);

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('v2_ticket', [
            'user_id' => $user->id,
            'subject' => 'Help with connection',
        ]);
        
        $this->assertDatabaseHas('v2_ticket_message', [
            'user_id' => $user->id,
            'message' => 'I cannot connect to the server.'
        ]);
    }

    public function test_user_can_fetch_their_tickets()
    {
        $user = User::factory()->create();
        
        // Creating a ticket indirectly through the API to ensure standard flow
        $this->actingAs($user)->postJson('/api/v1/user/ticket/save', [
            'subject' => 'Billing Issue',
            'level' => 0,
            'message' => 'I have a question about my bill.'
        ]);

        $response = $this->actingAs($user)->getJson('/api/v1/user/ticket/fetch');

        $response->assertStatus(200)
                 ->assertJsonPath('data.0.subject', 'Billing Issue');
    }
}
