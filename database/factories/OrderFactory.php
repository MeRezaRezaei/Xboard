<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'plan_id' => Plan::factory(),
            'period' => Plan::PERIOD_MONTHLY,
            'trade_no' => date('YmdHis') . Str::random(8),
            'total_amount' => 1000,
            'status' => Order::STATUS_PENDING,
            'type' => Order::TYPE_NEW_PURCHASE,
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Order::STATUS_COMPLETED,
                'paid_at' => time(),
            ];
        });
    }
}
