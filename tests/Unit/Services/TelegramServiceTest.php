<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\TelegramService;

class TelegramServiceTest extends TestCase
{
    public function test_telegram_service_initialization_and_methods()
    {
        // Instantiating with a dummy bot token
        $service = new TelegramService('123456789:ABCDefGHIJKlmnopQRSTuvWXYZ');

        $this->assertTrue(method_exists($service, 'sendMessage'));
        $this->assertTrue(method_exists($service, 'getMe'));
        $this->assertTrue(method_exists($service, 'setWebhook'));
    }
}
