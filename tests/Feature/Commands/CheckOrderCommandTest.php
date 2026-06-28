<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use App\Models\Order;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class CheckOrderCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_order_cancels_expired_pending_orders()
    {
        $user = User::factory()->create();
        $plan = Plan::factory()->create();

        // Create an order that has been pending for over 24 hours
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => Order::STATUS_PENDING,
            'created_at' => time() - 86401, // > 1 day ago
        ]);

        $exitCode = Artisan::call('check:order');

        $this->assertEquals(0, $exitCode);

        // Verify the order was cancelled
        $this->assertDatabaseHas('v2_order', [
            'id' => $order->id,
            'status' => Order::STATUS_CANCELLED, 
        ]);
    }

    public function test_check_order_ignores_recent_pending_orders()
    {
        $order = Order::factory()->create([
            'status' => Order::STATUS_PENDING,
            'created_at' => time() - 3600, // Only 1 hour ago
        ]);

        Artisan::call('check:order');

        // Verify the order remains pending
        $this->assertDatabaseHas('v2_order', [
            'id' => $order->id,
            'status' => Order::STATUS_PENDING, 
        ]);
    }
}
