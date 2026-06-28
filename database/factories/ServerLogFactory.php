<?php

namespace Database\Factories;

use App\Models\ServerLog;
use App\Models\User;
use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServerLogFactory extends Factory
{
    protected $model = ServerLog::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'server_id' => Server::factory(),
            'u' => $this->faker->numberBetween(1000, 5000),
            'd' => $this->faker->numberBetween(10000, 50000),
            'rate' => 1.0,
            'method' => 'aes-256-gcm',
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
