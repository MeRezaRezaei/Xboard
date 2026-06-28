<?php

namespace Database\Factories;

use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServerFactory extends Factory
{
    protected $model = Server::class;

    public function definition()
    {
        return [
            'group_id' => '["1"]',
            'route_id' => '[]',
            'name' => $this->faker->word() . ' Node',
            'parent_id' => null,
            'host' => $this->faker->ipv4(),
            'port' => $this->faker->numberBetween(10000, 60000),
            'server_port' => $this->faker->numberBetween(10000, 60000),
            'tls' => 0,
            'tags' => ['Premium'],
            'rate' => 1.0,
            'network' => 'tcp',
            'show' => 1,
            'sort' => 0,
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
