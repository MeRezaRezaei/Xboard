<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'subject' => $this->faker->sentence(),
            'level' => 0,
            'status' => 0,
            'reply_status' => 0,
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
