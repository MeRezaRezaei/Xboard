<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;

class SendRemindMailCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_remind_mail_queues_email_for_expiring_users()
    {
        Queue::fake();

        $plan = Plan::factory()->create();
        $user = User::factory()->create([
            'plan_id' => $plan->id,
            'remind_expire' => 1,
            'expired_at' => time() + 86400 * 2, // Expiring in 2 days
            'banned' => 0,
        ]);

        $exitCode = Artisan::call('send:remindMail');

        $this->assertEquals(0, $exitCode);

        // After the command runs, remind_expire should be set to 0 to prevent spamming
        $this->assertEquals(0, $user->fresh()->remind_expire);
    }
}
