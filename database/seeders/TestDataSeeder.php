<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Plan;
use App\Models\Order;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
        ]);

        $user = User::factory()->create([
            'email' => 'user@example.com',
        ]);

        $monthlyPlan = Plan::factory()->create([
            'name' => 'Monthly Pro Plan',
            'prices' => [
                Plan::PERIOD_MONTHLY => 1000,
            ],
        ]);

        $yearlyPlan = Plan::factory()->create([
            'name' => 'Yearly Ultra Plan',
            'prices' => [
                Plan::PERIOD_YEARLY => 10000,
            ],
        ]);

        Plan::factory()->hidden()->create([
            'name' => 'Hidden Secret Plan',
        ]);

        $user->update([
            'plan_id' => $monthlyPlan->id,
            'expired_at' => time() + (30 * 24 * 60 * 60),
        ]);

        Order::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $monthlyPlan->id,
            'period' => Plan::PERIOD_MONTHLY,
            'total_amount' => 1000,
        ]);

        Order::factory()->completed()->create([
            'user_id' => $user->id,
            'plan_id' => $yearlyPlan->id,
            'period' => Plan::PERIOD_YEARLY,
            'total_amount' => 10000,
        ]);
    }
}
