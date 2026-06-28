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
            'type' => 'socks',
            'group_ids' => [1],
            'route_ids' => [],
            'name' => $this->faker->word() . ' Node',
            'parent_id' => null,
            'host' => $this->faker->ipv4(),
            'port' => $this->faker->numberBetween(10000, 60000),
            'server_port' => $this->faker->numberBetween(10000, 60000),
            'tags' => ['Premium'],
            'rate' => 1.0,
            'show' => 1,
            'sort' => 0,
            'protocol_settings' => [
                'tls' => 0,
            ],
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
