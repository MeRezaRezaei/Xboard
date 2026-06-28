<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponAdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_generate_coupons()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->postJson('/api/v1/admin/coupon/generate', [
            'name' => 'Spring Sale',
            'type' => 2,
            'value' => 15, // 15% off
            'limit_use' => 100,
            'limit_use_with_user' => 1,
            'generate_count' => 5,
        ]);

        $response->assertStatus(200);
        
        // 5 coupons should be created
        $this->assertEquals(5, Coupon::where('name', 'Spring Sale')->count());
    }

    public function test_admin_can_drop_coupon()
    {
        $admin = User::factory()->admin()->create();
        $coupon = Coupon::factory()->create();

        $response = $this->actingAs($admin)->postJson('/api/v1/admin/coupon/drop', [
            'id' => $coupon->id
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('v2_coupon', ['id' => $coupon->id]);
    }
}
