<?php

namespace Database\Factories;

use App\Models\ServerGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServerGroupFactory extends Factory
{
    protected $model = ServerGroup::class;

    public function definition()
    {
        return [
            'name' => 'Group ' . $this->faker->numberBetween(1, 100),
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
