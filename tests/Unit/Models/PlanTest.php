<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Plan;
use InvalidArgumentException;

class PlanTest extends TestCase
{
    public function test_get_price_by_period()
    {
        $plan = Plan::factory()->make([
            'prices' => [
                Plan::PERIOD_MONTHLY => 1000,
                Plan::PERIOD_YEARLY => 10000,
            ]
        ]);

        $this->assertEquals(1000, $plan->getPriceByPeriod(Plan::PERIOD_MONTHLY));
        $this->assertEquals(10000, $plan->getPriceByPeriod(Plan::PERIOD_YEARLY));
        $this->assertNull($plan->getPriceByPeriod(Plan::PERIOD_QUARTERLY));
    }

    public function test_get_active_periods()
    {
        $plan = Plan::factory()->make([
            'prices' => [
                Plan::PERIOD_MONTHLY => 1000,
                Plan::PERIOD_QUARTERLY => 0,
                Plan::PERIOD_YEARLY => 10000,
            ]
        ]);

        $activePeriods = $plan->getActivePeriods();
        $this->assertArrayHasKey(Plan::PERIOD_MONTHLY, $activePeriods);
        $this->assertArrayHasKey(Plan::PERIOD_YEARLY, $activePeriods);
        $this->assertArrayNotHasKey(Plan::PERIOD_QUARTERLY, $activePeriods);
    }

    public function test_set_period_price()
    {
        $plan = Plan::factory()->make(['prices' => []]);
        $plan->setPeriodPrice(Plan::PERIOD_MONTHLY, 1500);

        $this->assertEquals(1500, $plan->getPriceByPeriod(Plan::PERIOD_MONTHLY));

        $this->expectException(InvalidArgumentException::class);
        $plan->setPeriodPrice('invalid_period', 100);
    }

    public function test_remove_period_price()
    {
        $plan = Plan::factory()->make([
            'prices' => [
                Plan::PERIOD_MONTHLY => 1000,
            ]
        ]);

        $plan->removePeriodPrice(Plan::PERIOD_MONTHLY);
        $this->assertNull($plan->getPriceByPeriod(Plan::PERIOD_MONTHLY));
    }

    public function test_can_reset_traffic()
    {
        $plan = Plan::factory()->make([
            'reset_traffic_method' => Plan::RESET_TRAFFIC_MONTHLY,
            'prices' => [
                Plan::PRICE_TYPE_RESET_TRAFFIC => 500,
            ]
        ]);
        $this->assertTrue($plan->canResetTraffic());

        $planNever = Plan::factory()->make([
            'reset_traffic_method' => Plan::RESET_TRAFFIC_NEVER,
            'prices' => [
                Plan::PRICE_TYPE_RESET_TRAFFIC => 500,
            ]
        ]);
        $this->assertFalse($planNever->canResetTraffic());

        $planNoPrice = Plan::factory()->make([
            'reset_traffic_method' => Plan::RESET_TRAFFIC_MONTHLY,
            'prices' => [
                Plan::PRICE_TYPE_RESET_TRAFFIC => 0,
            ]
        ]);
        $this->assertFalse($planNoPrice->canResetTraffic());
    }

    public function test_set_reset_traffic_method()
    {
        $plan = Plan::factory()->make();
        $plan->setResetTrafficMethod(Plan::RESET_TRAFFIC_YEARLY);
        $this->assertEquals(Plan::RESET_TRAFFIC_YEARLY, $plan->reset_traffic_method);

        $this->expectException(InvalidArgumentException::class);
        $plan->setResetTrafficMethod(999);
    }
}
