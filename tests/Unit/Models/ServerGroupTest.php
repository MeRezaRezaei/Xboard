<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\ServerGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServerGroupTest extends TestCase
{
    use RefreshDatabase;

    public function test_server_group_creation()
    {
        $group = ServerGroup::factory()->create([
            'name' => 'Premium Users'
        ]);

        $this->assertDatabaseHas('v2_server_group', [
            'id' => $group->id,
            'name' => 'Premium Users'
        ]);
    }
}
