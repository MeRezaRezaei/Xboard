<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Order;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_relationships()
    {
        $user = User::factory()->create();
        $plan = Plan::factory()->create();
        
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
        ]);

        $this->assertInstanceOf(User::class, $order->user);
        $this->assertEquals($user->id, $order->user->id);
        
        $this->assertInstanceOf(Plan::class, $order->plan);
        $this->assertEquals($plan->id, $order->plan->id);
    }
}
