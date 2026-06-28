<?php

namespace Tests\Unit\WebSocket;

use Tests\TestCase;
use App\WebSocket\NodeEventHandlers;

class NodeEventHandlersTest extends TestCase
{
    public function test_node_event_handlers_has_required_methods()
    {
        $this->assertTrue(method_exists(NodeEventHandlers::class, 'onWorkerStart'));
        $this->assertTrue(method_exists(NodeEventHandlers::class, 'onConnect'));
        $this->assertTrue(method_exists(NodeEventHandlers::class, 'onMessage'));
        $this->assertTrue(method_exists(NodeEventHandlers::class, 'onClose'));
    }
}
