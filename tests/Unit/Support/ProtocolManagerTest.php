<?php

namespace Tests\Unit\Support;

use Tests\TestCase;
use App\Support\ProtocolManager;
use App\Models\User;
use App\Models\Server;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProtocolManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_protocol_manager_is_instantiable()
    {
        $this->assertTrue(class_exists(ProtocolManager::class));
    }
}
