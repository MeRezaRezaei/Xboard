<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Models\Order;
use App\Jobs\OrderHandleJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

class OrderHandleJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_handle_job_can_be_dispatched()
    {
        Queue::fake();

        $order = Order::factory()->create([
            'trade_no' => 'TEST_TRADE_123456789'
        ]);

        OrderHandleJob::dispatch($order->trade_no);

        Queue::assertPushed(OrderHandleJob::class);
    }
}
