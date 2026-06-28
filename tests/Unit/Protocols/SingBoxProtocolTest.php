<?php

namespace Tests\Unit\Protocols;

use Tests\TestCase;
use App\Protocols\SingBox;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SingBoxProtocolTest extends TestCase
{
    use RefreshDatabase;

    public function test_singbox_protocol_class_exists()
    {
        $this->assertTrue(class_exists(SingBox::class));
    }
}
