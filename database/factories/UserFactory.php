<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password123'),
            'uuid' => $this->faker->uuid(),
            'token' => Str::random(16),
            'transfer_enable' => 100 * 1024 * 1024 * 1024, // 100 GB
            'u' => 0,
            'd' => 0,
            'banned' => 0,
            'remind_expire' => 1,
            'remind_traffic' => 1,
            'balance' => 0,
            'commission_balance' => 0,
            'commission_rate' => 10.0,
            'commission_type' => User::COMMISSION_TYPE_SYSTEM,
            'commission_auto_check' => 1,
            'reset_count' => 0,
            'is_admin' => 0,
            'is_staff' => 0,
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_admin' => 1,
                'is_staff' => 1,
            ];
        });
    }

    public function activePlan()
    {
        return $this->state(function (array $attributes) {
            return [
                'plan_id' => 1, // Will be overridden in tests
                'expired_at' => time() + (30 * 24 * 60 * 60), // +30 days
            ];
        });
    }
}
