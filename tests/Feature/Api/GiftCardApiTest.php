<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\GiftCardCode;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GiftCardApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_redeem_gift_card()
    {
        $user = User::factory()->create([
            'balance' => 0,
        ]);
        
        $giftCard = GiftCardCode::factory()->create([
            'code' => 'GIFTCARD-5000',
            'balance' => 5000,
            'status' => 0,
        ]);

        $response = $this->actingAs($user)->postJson('/api/v1/user/gift-card/redeem', [
            'code' => 'GIFTCARD-5000'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('v2_user', [
            'id' => $user->id,
            'balance' => 5000,
        ]);

        $this->assertDatabaseHas('v2_gift_card_code', [
            'id' => $giftCard->id,
            'status' => 1,
        ]);
    }

    public function test_user_cannot_redeem_used_gift_card()
    {
        $user = User::factory()->create([
            'balance' => 0,
        ]);
        
        $giftCard = GiftCardCode::factory()->used()->create([
            'code' => 'GIFTCARD-USED',
            'balance' => 5000,
        ]);

        $response = $this->actingAs($user)->postJson('/api/v1/user/gift-card/redeem', [
            'code' => 'GIFTCARD-USED'
        ]);

        $response->assertStatus(500); // Or the expected exception status code
        
        $this->assertDatabaseHas('v2_user', [
            'id' => $user->id,
            'balance' => 0,
        ]);
    }
}
