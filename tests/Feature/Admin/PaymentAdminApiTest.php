<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentAdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_fetch_payments()
    {
        $admin = User::factory()->admin()->create();
        Payment::factory()->create(['name' => 'CryptoPay']);

        $response = $this->actingAs($admin)->getJson($this->getAdminUri('payment/fetch'));

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'CryptoPay']);
    }

    public function test_admin_can_create_payment_method()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->postJson($this->getAdminUri('payment/save'), [
            'name' => 'Stripe Integration',
            'payment' => 'Stripe',
            'icon' => 'stripe',
            'config' => '{"public_key": "pk_test_123"}',
            'enable' => 1,
            'sort' => 1,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('v2_payment', ['name' => 'Stripe Integration']);
    }

    public function test_admin_can_drop_payment_method()
    {
        $admin = User::factory()->admin()->create();
        $payment = Payment::factory()->create();

        $response = $this->actingAs($admin)->postJson($this->getAdminUri('payment/drop'), [
            'id' => $payment->id
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('v2_payment', ['id' => $payment->id]);
    }
}
