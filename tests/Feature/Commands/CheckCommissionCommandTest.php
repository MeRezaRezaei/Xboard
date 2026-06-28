<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class CheckCommissionCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_commission_command_executes()
    {
        $inviter = User::factory()->create([
            'commission_balance' => 0,
        ]);
        
        $invitee = User::factory()->create([
            'invite_user_id' => $inviter->id,
        ]);

        $order = Order::factory()->create([
            'user_id' => $invitee->id,
            'status' => 3, // STATUS_COMPLETED
            'commission_status' => 0, // NEW / PENDING
            'commission_balance' => 150,
            'total_amount' => 1500,
        ]);

        $exitCode = Artisan::call('check:commission');

        $this->assertEquals(0, $exitCode);

        // Verify the order's commission status was updated to recorded
        $this->assertDatabaseHas('v2_order', [
            'id' => $order->id,
            'commission_status' => 1, 
        ]);
    }
}
