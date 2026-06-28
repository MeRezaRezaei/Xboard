<?php

namespace Tests\Unit\Protocols;

use Tests\TestCase;
use App\Protocols\Clash;
use App\Protocols\ClashMeta;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClashProtocolTest extends TestCase
{
    use RefreshDatabase;

    public function test_clash_protocol_classes_exist()
    {
        $this->assertTrue(class_exists(Clash::class));
        $this->assertTrue(class_exists(ClashMeta::class));
    }
}
