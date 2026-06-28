<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_check_valid_coupon()
    {
        $user = User::factory()->create();
        $coupon = Coupon::factory()->create([
            'code' => 'DISCOUNT20',
            'type' => 1,
            'value' => 2000,
        ]);

        $response = $this->actingAs($user)->postJson('/api/v1/user/coupon/check', [
            'code' => 'DISCOUNT20'
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.type', 1)
                 ->assertJsonPath('data.value', 2000);
    }

    public function test_user_cannot_check_expired_coupon()
    {
        $user = User::factory()->create();
        $coupon = Coupon::factory()->expired()->create([
            'code' => 'EXPIRED10',
        ]);

        $response = $this->actingAs($user)->postJson('/api/v1/user/coupon/check', [
            'code' => 'EXPIRED10'
        ]);

        // Depending on your ApiException handling, it usually returns 400 or 500 with a specific message
        $response->assertStatus(500); 
    }
}
