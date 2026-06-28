<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Jobs\TrafficFetchJob;
use App\Models\Server;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

class TrafficFetchJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_traffic_fetch_job_can_be_dispatched()
    {
        Queue::fake();

        $server = Server::factory()->create([
            'name' => 'Traffic Node',
            'host' => 'traffic.example.com',
            'rate' => 1.0,
        ]);
        
        $user = User::factory()->create([
            'u' => 0,
            'd' => 0,
            'transfer_enable' => 100 * 1024 * 1024 * 1024,
        ]);

        // Simulating the payload format sent from NodeWorker/Workerman to Xboard
        $data = [
            $user->id => [
                $user->id,
                1048576, // u (1MB)
                2097152  // d (2MB)
            ]
        ];

        TrafficFetchJob::dispatch($server->toArray(), $data, 'socks', time());

        Queue::assertPushed(TrafficFetchJob::class);
    }
}
