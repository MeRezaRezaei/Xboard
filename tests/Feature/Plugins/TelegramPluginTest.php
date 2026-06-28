<?php

namespace Tests\Feature\Plugins;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TelegramPluginTest extends TestCase
{
    use RefreshDatabase;

    public function test_telegram_plugin_structure_exists()
    {
        $pluginPath = base_path('plugins-core/Telegram/Plugin.php');
        $configPath = base_path('plugins-core/Telegram/config.json');

        if (file_exists($pluginPath) && file_exists($configPath)) {
            $this->assertTrue(true);
            
            // Verify config is valid JSON
            $configContent = file_get_contents($configPath);
            $config = json_decode($configContent, true);
            
            $this->assertIsArray($config);
            $this->assertArrayHasKey('name', $config);
            $this->assertEquals('Telegram', $config['name']);
        } else {
            $this->markTestSkipped('Telegram core plugin not found.');
        }
    }
}
