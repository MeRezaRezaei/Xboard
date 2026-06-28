<?php

namespace Tests\Browser;

use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    public function test_basic_example(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->assertSee('Xboard');
        });
    }
}
