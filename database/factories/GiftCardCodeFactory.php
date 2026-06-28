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
            'template_id' => null,
            'code' => strtoupper(Str::random(12)),
            'balance' => 5000, // $50.00 equivalent
            'status' => 0, // 0: Unused, 1: Used
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
