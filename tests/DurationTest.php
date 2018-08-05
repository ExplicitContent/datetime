<?php

namespace ExplicitContent\DateTime;

use PHPUnit\Framework\TestCase;

/**
 *
 */
final class DurationTest extends TestCase
{
    public function testVeryBasicFeatures(): void
    {
        $this->assertSame(42, Duration::seconds(42)->toSeconds());
        $this->assertSame(2520, Duration::minutes(42)->toSeconds());
        $this->assertSame(151200, Duration::hours(42)->toSeconds());
        $this->assertSame(2, Duration::fromString('PT2S')->toSeconds());
        $this->assertSame(151320, Duration::hours(42)->plusMinutes(2)->toSeconds());
    }
}
