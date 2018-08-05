<?php

namespace ExplicitContent\DateTime;

use ExplicitContent\Assertion\Assertion;

/**
 *
 */
final class Month
{
    private $month;

    private const JANUARY = 'January';
    private const FEBRUARY = 'February';
    private const MARCH = 'March';
    private const APRIL = 'April';
    private const MAY = 'May';
    private const JUNE = 'June';
    private const JULY = 'July';
    private const AUGUST = 'August';
    private const SEPTEMBER = 'September';
    private const OCTOBER = 'October';
    private const NOVEMBER = 'November';
    private const DECEMBER = 'December';

    private const MAP = [
        self::JANUARY => 1,
        self::FEBRUARY => 2,
        self::MARCH => 3,
        self::APRIL => 4,
        self::MAY => 5,
        self::JUNE => 6,
        self::JULY => 7,
        self::AUGUST => 8,
        self::SEPTEMBER => 9,
        self::OCTOBER => 10,
        self::NOVEMBER => 11,
        self::DECEMBER => 12,
    ];

    public static function january(): self
    {
        return new self(self::JANUARY);
    }

    public static function february(): self
    {
        return new self(self::FEBRUARY);
    }

    public static function march(): self
    {
        return new self(self::MARCH);
    }

    public static function april(): self
    {
        return new self(self::APRIL);
    }

    public static function may(): self
    {
        return new self(self::MAY);
    }

    public static function june(): self
    {
        return new self(self::JUNE);
    }

    public static function july(): self
    {
        return new self(self::JULY);
    }

    public static function august(): self
    {
        return new self(self::AUGUST);
    }

    public static function september(): self
    {
        return new self(self::SEPTEMBER);
    }

    public static function october(): self
    {
        return new self(self::OCTOBER);
    }

    public static function november(): self
    {
        return new self(self::NOVEMBER);
    }

    public static function december(): self
    {
        return new self(self::DECEMBER);
    }

    public static function fromInt(int $month)
    {
        Assertion::true($month >= 1 && $month <= 12, sprintf('Invalid month number: %d.', $month));

        return new self($month);
    }

    private function __construct(string $month)
    {
        Assertion::true(isset(self::MAP[$month]), sprintf('Invalid month: "%s".', $month));

        $this->month = $month;
    }

    public function equals(self $month): bool
    {
        return $this->month === $month->month;
    }

    public function toInt(): int
    {
        return self::MAP[$this->month];
    }

    public function toString(): string
    {
        return $this->month;
    }
}
