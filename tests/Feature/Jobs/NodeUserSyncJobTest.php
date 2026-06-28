<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Jobs\NodeUserSyncJob;
use App\Models\Server;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

class NodeUserSyncJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_node_user_sync_job_can_be_dispatched()
    {
        Queue::fake();

        $server = Server::factory()->create([
            'name' => 'Sync Test Node',
            'host' => 'node.example.com',
            'port' => 443,
            'server_port' => 443,
            'rate' => 1.0,
        ]);

        NodeUserSyncJob::dispatch($server->id);

        Queue::assertPushed(NodeUserSyncJob::class);
    }
}
