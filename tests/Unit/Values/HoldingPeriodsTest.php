<?php

namespace Tests\Unit\Values;

use App\Values\Events\HoldingPeriods;
use App\Values\Events\Period;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;

class HoldingPeriodsTest extends TestCase
{
    /** @test */
    public function testMergedSections()
    {
        $sections = new HoldingPeriods(
            new Period(
                CarbonImmutable::create(2022, 4, 1, 12, 00),
                CarbonImmutable::create(2022, 4, 1, 24, 00),
            ),
            new Period(
                CarbonImmutable::create(2022, 4, 1, 22, 00),
                CarbonImmutable::create(2022, 4, 2, 20, 00),
            ),
            new Period(
                CarbonImmutable::create(2022, 4, 1, 10, 00),
                CarbonImmutable::create(2022, 4, 2, 24, 00),
            ),
            new Period(
                CarbonImmutable::create(2022, 4, 3, 10, 00),
                CarbonImmutable::create(2022, 4, 3, 22, 00),
            )
        );

        $this->assertEquals(
            [
                new Period(
                    Carbon::create(2022, 4, 1, 10, 00),
                    Carbon::create(2022, 4, 2, 24, 00),
                ),
                new Period(
                    Carbon::create(2022, 4, 3, 10, 00),
                    Carbon::create(2022, 4, 3, 22, 00),
                ),
            ],
            $sections->all(),
        );
    }

    /** @test */
    public function testSameStartDate()
    {
        $sections = new HoldingPeriods(
            new Period(
                Carbon::create(2022, 4, 1, 12, 00),
                Carbon::create(2022, 4, 1, 24, 00),
            ),
            new Period(
                Carbon::create(2022, 4, 1, 12, 00),
                Carbon::create(2022, 4, 1, 14, 00),
            ),
        );

        $this->assertEquals(
            [
                new Period(
                    Carbon::create(2022, 4, 1, 12, 00),
                    Carbon::create(2022, 4, 1, 24, 00),
                ),
            ],
            $sections->all(),
        );
    }
}
