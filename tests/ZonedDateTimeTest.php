<?php

namespace ExplicitContent\DateTime;

use PHPUnit\Framework\TestCase;

/**
 *
 */
final class ZonedDateTimeTest extends TestCase
{
    public function testVeryBasicFeatures(): void
    {
        $time = ZonedDateTime::fromYmdHis('2000-01-01 00:00:00', TimeZone::utc());

        $this->assertSame('2000-01-01T00:00:00+00:00', $time->toRfc3399());
        $this->assertSame('2000-01-01T00:00:42+00:00', $time->plusSeconds(42)->toRfc3399());
        $this->assertSame('1999-12-31T23:18:00+00:00', $time->minusMinutes(42)->toRfc3399());
        $this->assertSame('2042-01-01T00:00:00+00:00', $time->plusYears(42)->toRfc3399());
        $this->assertSame(946684800, $time->toUnixTimestamp());
        $this->assertTrue(ZonedDateTime::fromUnixTimestamp(946684800, TimeZone::msk())->equals($time));
        $this->assertTrue($time->toDayOfWeek()->equals(DayOfWeek::saturday()));
        $this->assertTrue($time->toLocalDate()->getYear()->isLeap());
        $this->assertEquals(-2, $time->getMinutesDiff(ZonedDateTime::fromYmdHis('2000-01-01 00:02:01', TimeZone::utc())));
    }
}
