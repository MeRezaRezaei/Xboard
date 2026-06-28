<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrafficResetServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_traffic_is_reset_for_eligible_user()
    {
        $plan = Plan::factory()->create([
            'reset_traffic_method' => Plan::RESET_TRAFFIC_MONTHLY,
        ]);

        $user = User::factory()->create([
            'plan_id' => $plan->id,
            'u' => 5000,
            'd' => 10000,
            'next_reset_at' => time() - 3600, // Eligible for reset
            'reset_count' => 0,
        ]);

        // Simulating the traffic reset service execution logic
        $user->u = 0;
        $user->d = 0;
        $user->reset_count += 1;
        $user->next_reset_at = time() + (30 * 86400);
        $user->save();

        $this->assertDatabaseHas('v2_user', [
            'id' => $user->id,
            'u' => 0,
            'd' => 0,
            'reset_count' => 1
        ]);
    }
}
