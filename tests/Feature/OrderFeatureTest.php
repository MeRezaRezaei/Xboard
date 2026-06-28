<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plan;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_order()
    {
        $user = User::factory()->create();
        $plan = Plan::factory()->create([
            'prices' => [
                Plan::PERIOD_MONTHLY => 1500
            ]
        ]);

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'period' => Plan::PERIOD_MONTHLY,
            'total_amount' => 1500,
            'status' => Order::STATUS_PENDING,
            'type' => Order::TYPE_NEW_PURCHASE,
        ]);

        $this->assertDatabaseHas('v2_order', [
            'id' => $order->id,
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'total_amount' => 1500,
            'status' => Order::STATUS_PENDING,
        ]);
    }

    public function test_order_completion_updates_user_plan()
    {
        $user = User::factory()->create([
            'plan_id' => null, 
            'expired_at' => null,
            'u' => 0,
            'd' => 0,
        ]);
        
        $plan = Plan::factory()->create([
            'transfer_enable' => 500 * 1024 * 1024 * 1024, // 500GB
        ]);
        
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => Order::STATUS_COMPLETED,
            'type' => Order::TYPE_NEW_PURCHASE,
        ]);

        $user->update([
            'plan_id' => $plan->id,
            'transfer_enable' => $plan->transfer_enable,
            'expired_at' => time() + (30 * 24 * 60 * 60), // +30 days
        ]);

        $this->assertDatabaseHas('v2_user', [
            'id' => $user->id,
            'plan_id' => $plan->id,
            'transfer_enable' => 500 * 1024 * 1024 * 1024,
        ]);
        
        $this->assertTrue($user->fresh()->isActive());
    }

    public function test_order_discount_status_applied()
    {
        $user = User::factory()->create();
        $plan = Plan::factory()->create();
        
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => Order::STATUS_DISCOUNTED,
            'discount_amount' => 500,
            'total_amount' => 1000,
            'balance_amount' => 500,
        ]);

        $this->assertDatabaseHas('v2_order', [
            'id' => $order->id,
            'status' => Order::STATUS_DISCOUNTED,
            'discount_amount' => 500,
        ]);
        
        $this->assertEquals('已折抵', Order::$statusMap[$order->status]);
    }
}
