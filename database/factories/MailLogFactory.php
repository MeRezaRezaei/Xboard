<?php

namespace Database\Factories;

use App\Models\MailLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class MailLogFactory extends Factory
{
    protected $model = MailLog::class;

    public function definition()
    {
        return [
            'email' => $this->faker->safeEmail(),
            'subject' => $this->faker->sentence(),
            'template_name' => 'notify',
            'error' => null,
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
