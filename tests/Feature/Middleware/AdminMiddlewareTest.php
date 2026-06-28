<?php

namespace Tests\Feature\Middleware;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Define a temporary route protected by the Admin middleware
        Route::middleware([\App\Http\Middleware\Admin::class])->get('/_test/admin-only', function () {
            return response()->json(['message' => 'Admin Access Granted']);
        });
    }

    public function test_admin_can_access_admin_routes()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->getJson('/_test/admin-only');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Admin Access Granted']);
    }

    public function test_regular_user_cannot_access_admin_routes()
    {
        $user = User::factory()->create([
            'is_admin' => 0,
            'is_staff' => 0,
        ]);

        $response = $this->actingAs($user)->getJson('/_test/admin-only');

        // Expecting a forbidden status or unauthorized depending on your exception handler
        $response->assertStatus(403);
    }
}
