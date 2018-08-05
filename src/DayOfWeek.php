<?php

namespace ExplicitContent\DateTime;

use ExplicitContent\Assertion\Assertion;

/**
 *
 */
final class DayOfWeek
{
    private const MONDAY = 1;
    private const TUESDAY = 2;
    private const WEDNESDAY = 3;
    private const THURSDAY = 4;
    private const FRIDAY = 5;
    private const SATURDAY = 6;
    private const SUNDAY = 0;

    private $dayOfWeek;

    public static function monday(): self
    {
        return new self(self::MONDAY);
    }

    public static function tuesday(): self
    {
        return new self(self::TUESDAY);
    }

    public static function wednesday(): self
    {
        return new self(self::WEDNESDAY);
    }

    public static function thursday(): self
    {
        return new self(self::THURSDAY);
    }

    public static function friday(): self
    {
        return new self(self::FRIDAY);
    }

    public static function saturday(): self
    {
        return new self(self::SATURDAY);
    }

    public static function sunday(): self
    {
        return new self(self::SUNDAY);
    }

    public static function fromInt(int $dayOfWeek): self
    {
        return new self($dayOfWeek);
    }

    private function __construct(int $dayOfWeek)
    {
        Assertion::true($dayOfWeek >= 0 && $dayOfWeek <= 6, sprintf('Invalid day of week: "%s".', $dayOfWeek));

        $this->dayOfWeek = $dayOfWeek;
    }

    public function isWeekend(): bool
    {
        return $this->dayOfWeek === self::SATURDAY || $this->dayOfWeek === self::SUNDAY;
    }

    public function equals(self $dayOfWeek): bool
    {
        return $this->dayOfWeek === $dayOfWeek->dayOfWeek;
    }
}
