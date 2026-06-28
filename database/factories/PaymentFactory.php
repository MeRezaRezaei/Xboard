<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'payment' => 'AlipayF2f',
            'name' => 'Alipay Secure',
            'icon' => 'alipay',
            'config' => '{"app_id": "123456789"}',
            'notify_domain' => null,
            'handling_fee_fixed' => 0,
            'handling_fee_percent' => 0,
            'enable' => 1,
            'sort' => 0,
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
