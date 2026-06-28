<?php

namespace Database\Factories;

use App\Models\CommissionLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommissionLogFactory extends Factory
{
    protected $model = CommissionLog::class;

    public function definition()
    {
        return [
            'invite_user_id' => User::factory(),
            'user_id' => User::factory(),
            'trade_no' => date('YmdHis') . Str::random(8),
            'order_amount' => 1000,
            'get_amount' => 100, // 10%
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
