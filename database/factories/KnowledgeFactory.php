<?php

namespace Database\Factories;

use App\Models\Knowledge;
use Illuminate\Database\Eloquent\Factories\Factory;

class KnowledgeFactory extends Factory
{
    protected $model = Knowledge::class;

    public function definition()
    {
        return [
            'language' => 'en-US',
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'sort' => 0,
            'show' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
