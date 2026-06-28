<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;

class CheckTrafficExceededCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_notifies_users_when_traffic_threshold_exceeded()
    {
        Queue::fake();

        $plan = Plan::factory()->create();
        
        $user = User::factory()->create([
            'plan_id' => $plan->id,
            'transfer_enable' => 100 * 1024 * 1024 * 1024, // 100 GB
            'u' => 40 * 1024 * 1024 * 1024, // 40 GB
            'd' => 45 * 1024 * 1024 * 1024, // 45 GB (Total 85%, over the typical 80% threshold)
            'remind_traffic' => 1,
            'banned' => 0,
        ]);

        $exitCode = Artisan::call('check:trafficExceeded');

        $this->assertEquals(0, $exitCode);

        // Verify the flag is flipped to prevent spam
        $this->assertEquals(0, $user->fresh()->remind_traffic);
    }
}
