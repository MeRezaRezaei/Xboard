<?php

namespace Database\Factories;

use App\Models\Notice;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoticeFactory extends Factory
{
    protected $model = Notice::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'show' => 1,
            'img_url' => $this->faker->imageUrl(),
            'tags' => ['update'],
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
