<?php

namespace ExplicitContent\DateTime;

use PHPUnit\Framework\TestCase;

/**
 *
 */
final class LocalTimeTest extends TestCase
{
    public function testVeryBasicFeatures(): void
    {
        $this->assertSame('00:23:52', LocalTime::fromSecondOfDay(1432)->toHis());
        $this->assertSame(1432, LocalTime::fromString('00:23:52')->toSecondsOfDay());
        $this->assertSame(47655, LocalTime::from(13, 14, 15)->toSecondsOfDay());
        $this->assertSame('13:14:15', LocalTime::fromSecondOfDay(47655)->toHis());
        $this->assertTrue(
            LocalTime::fromString('00:23:52')->isBefore(LocalTime::fromString('01:23:52'))
        );
        $this->assertTrue(
            LocalTime::fromString('03:23:52')->isAfter(LocalTime::fromString('02:01:01'))
        );
    }
}
