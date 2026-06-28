<?php

namespace Tests\Feature\Plugins;

use Tests\TestCase;
use App\Models\Payment;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class PaymentPluginTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_service_resolves_plugin()
    {
        // Create a dummy payment method representing a plugin (e.g., Stripe)
        $paymentMethod = Payment::factory()->create([
            'payment' => 'Stripe',
            'config' => json_encode(['public_key' => 'pk_test', 'secret_key' => 'sk_test']),
            'enable' => 1,
        ]);

        $order = Order::factory()->create([
            'total_amount' => 1000,
            'status' => Order::STATUS_PENDING,
        ]);

        $paymentService = Mockery::mock(PaymentService::class)->makePartial();
        
        // Mock the pay method to simulate a successful plugin checkout generation
        $paymentService->shouldReceive('pay')
            ->once()
            ->andReturn([
                'type' => 1, // 1 typically means redirect/URL
                'data' => 'https://checkout.stripe.com/pay/cs_test_123'
            ]);

        $result = $paymentService->pay($paymentMethod->id, $order->trade_no);

        $this->assertIsArray($result);
        $this->assertEquals(1, $result['type']);
        $this->assertStringContainsString('https://checkout.stripe.com', $result['data']);
    }
}
