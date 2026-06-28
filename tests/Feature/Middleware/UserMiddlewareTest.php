<?php

namespace Tests\Feature\Middleware;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

class UserMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Define a temporary route protected by the User middleware
        Route::middleware([\App\Http\Middleware\User::class])->get('/_test/user-only', function () {
            return response()->json(['message' => 'User Access Granted']);
        });
    }

    public function test_active_user_can_access_user_routes()
    {
        $user = User::factory()->create([
            'banned' => 0,
        ]);

        $response = $this->actingAs($user)->getJson('/_test/user-only');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'User Access Granted']);
    }

    public function test_banned_user_is_rejected_by_middleware()
    {
        $user = User::factory()->create([
            'banned' => 1,
        ]);

        $response = $this->actingAs($user)->getJson('/_test/user-only');

        $response->assertStatus(403); 
    }
}
