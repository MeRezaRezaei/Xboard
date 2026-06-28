<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_active()
    {
        $user = User::factory()->make([
            'banned' => 0,
            'expired_at' => time() + 3600,
            'plan_id' => 1,
        ]);
        $this->assertTrue($user->isActive());

        $bannedUser = User::factory()->make(['banned' => 1, 'plan_id' => 1]);
        $this->assertFalse($bannedUser->isActive());

        $expiredUser = User::factory()->make(['expired_at' => time() - 3600, 'plan_id' => 1]);
        $this->assertFalse($expiredUser->isActive());

        $noPlanUser = User::factory()->make(['plan_id' => null]);
        $this->assertFalse($noPlanUser->isActive());
    }

    public function test_get_total_used_traffic()
    {
        $user = User::factory()->make(['u' => 1000, 'd' => 2000]);
        $this->assertEquals(3000, $user->getTotalUsedTraffic());
    }

    public function test_get_remaining_traffic()
    {
        $user = User::factory()->make([
            'transfer_enable' => 10000,
            'u' => 1000,
            'd' => 2000,
        ]);
        $this->assertEquals(7000, $user->getRemainingTraffic());

        $userOver = User::factory()->make([
            'transfer_enable' => 5000,
            'u' => 3000,
            'd' => 4000,
        ]);
        $this->assertEquals(0, $userOver->getRemainingTraffic());
    }

    public function test_is_available()
    {
        $user = User::factory()->make([
            'banned' => 0,
            'expired_at' => time() + 3600,
            'plan_id' => 1,
            'transfer_enable' => 10000,
            'u' => 1000,
            'd' => 2000,
        ]);
        $this->assertTrue($user->isAvailable());

        $userNoTraffic = User::factory()->make([
            'banned' => 0,
            'expired_at' => time() + 3600,
            'plan_id' => 1,
            'transfer_enable' => 1000,
            'u' => 1000,
            'd' => 2000,
        ]);
        $this->assertFalse($userNoTraffic->isAvailable());
    }

    public function test_get_traffic_usage_percentage()
    {
        $user = User::factory()->make([
            'transfer_enable' => 10000,
            'u' => 2000,
            'd' => 3000,
        ]);
        $this->assertEquals(50.0, $user->getTrafficUsagePercentage());

        $userZero = User::factory()->make(['transfer_enable' => 0]);
        $this->assertEquals(0, $userZero->getTrafficUsagePercentage());

        $userOver = User::factory()->make([
            'transfer_enable' => 10000,
            'u' => 8000,
            'd' => 4000,
        ]);
        $this->assertEquals(100.0, $userOver->getTrafficUsagePercentage());
    }

    public function test_should_reset_traffic()
    {
        $user = User::factory()->make([
            'banned' => 0,
            'expired_at' => time() + 3600,
            'plan_id' => 1,
            'next_reset_at' => time() - 3600,
        ]);
        $this->assertTrue($user->shouldResetTraffic());

        $userFutureReset = User::factory()->make([
            'banned' => 0,
            'expired_at' => time() + 3600,
            'plan_id' => 1,
            'next_reset_at' => time() + 3600,
        ]);
        $this->assertFalse($userFutureReset->shouldResetTraffic());
    }
}
