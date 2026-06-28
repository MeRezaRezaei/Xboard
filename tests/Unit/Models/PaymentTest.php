<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_creation_and_attributes()
    {
        $payment = Payment::factory()->create([
            'handling_fee_fixed' => 50,
            'handling_fee_percent' => 2.5,
        ]);
        
        $this->assertDatabaseHas('v2_payment', [
            'id' => $payment->id,
            'handling_fee_fixed' => 50,
            'handling_fee_percent' => 2.5,
        ]);
        
        $this->assertEquals(50, $payment->handling_fee_fixed);
        $this->assertEquals(2.5, $payment->handling_fee_percent);
    }
}
