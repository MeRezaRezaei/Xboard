<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuestPlanApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_fetch_visible_plans()
    {
        $visiblePlan = Plan::factory()->create([
            'name' => 'Visible Plan',
            'show' => 1,
            'sort' => 1,
        ]);

        $hiddenPlan = Plan::factory()->hidden()->create([
            'name' => 'Hidden Plan',
            'show' => 0,
        ]);

        $response = $this->getJson('/api/v1/guest/plan/fetch');

        $response->assertStatus(200)
                 ->assertJsonPath('data.0.id', $visiblePlan->id)
                 ->assertJsonPath('data.0.name', 'Visible Plan')
                 ->assertJsonMissing(['name' => 'Hidden Plan']);
    }
}
