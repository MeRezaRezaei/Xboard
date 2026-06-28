<?php

namespace Tests\Unit\Protocols;

use Tests\TestCase;
use App\Protocols\Shadowrocket;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShadowrocketProtocolTest extends TestCase
{
    use RefreshDatabase;

    public function test_shadowrocket_protocol_class_exists()
    {
        $this->assertTrue(class_exists(Shadowrocket::class));
    }
}
