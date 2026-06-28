<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Server;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServerTest extends TestCase
{
    use RefreshDatabase;

    public function test_server_creation()
    {
        $server = Server::factory()->create([
            'name' => 'Hong Kong 01',
            'host' => 'hk.example.com',
            'rate' => 1.5,
        ]);

        $this->assertDatabaseHas('v2_server', [
            'id' => $server->id,
            'name' => 'Hong Kong 01',
            'host' => 'hk.example.com',
            'rate' => 1.5,
        ]);
    }
}
