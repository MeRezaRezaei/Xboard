<?php

namespace Database\Factories;

use App\Models\GiftCardCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GiftCardCodeFactory extends Factory
{
    protected $model = GiftCardCode::class;

    public function definition()
    {
        return [
            'template_id' => 1,
            'code' => strtoupper(Str::random(12)),
            'status' => 0,
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }

    public function used()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 1,
            ];
        });
    }
}
