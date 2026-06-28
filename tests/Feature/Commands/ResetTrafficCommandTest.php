<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class ResetTrafficCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_traffic_command_executes_successfully()
    {
        $plan = Plan::factory()->create([
            'reset_traffic_method' => Plan::RESET_TRAFFIC_MONTHLY,
        ]);

        $user = User::factory()->create([
            'plan_id' => $plan->id,
            'u' => 5000,
            'd' => 10000,
            'next_reset_at' => time() - 86400,
        ]);

        $exitCode = Artisan::call('reset:traffic');

        $this->assertEquals(0, $exitCode);
        $this->assertNotNull($user->fresh()->id);
    }
}
