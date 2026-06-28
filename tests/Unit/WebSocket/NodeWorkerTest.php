<?php

namespace Tests\Unit\WebSocket;

use Tests\TestCase;
use App\WebSocket\NodeWorker;

class NodeWorkerTest extends TestCase
{
    public function test_node_worker_is_instantiable()
    {
        $this->assertTrue(class_exists(NodeWorker::class));
    }
}
