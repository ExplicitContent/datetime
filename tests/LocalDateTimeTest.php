<?php

namespace ExplicitContent\DateTime;

use PHPUnit\Framework\TestCase;

/**
 *
 */
final class LocalDateTimeTest extends TestCase
{
    public function testVeryBasicFeatures(): void
    {
        $this->assertSame('2000-01-02 04:05:06', LocalDateTime::fromYmdHis('2000-01-02 04:05:06')->toYmdHis());
    }
}
