<?php

namespace Tests\Unit\Observers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_creation_triggers_default_attributes()
    {
        // Many systems use Observers (like UserObserver) to automatically 
        // generate tokens, UUIDs, or default balances upon creation.
        // We ensure that the User factory triggers these successfully without breaking.
        
        $user = User::factory()->create();

        $this->assertNotNull($user->uuid);
        $this->assertNotNull($user->token);
        $this->assertEquals(0, $user->balance);
        
        // Verify default timestamps map correctly
        $this->assertGreaterThan(0, $user->created_at);
        $this->assertGreaterThan(0, $user->updated_at);
    }
    
    public function test_user_email_is_always_lowercase()
    {
        // Tests the Attribute casting defined in the User model
        $user = User::factory()->create([
            'email' => 'TESTING.EMAIL@EXAMPLE.COM',
        ]);
        
        $this->assertEquals('testing.email@example.com', $user->email);
    }
}
