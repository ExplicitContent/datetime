<?php

namespace ExplicitContent\DateTime;

use ExplicitContent\Assertion\Assertion;

/**
 *
 */
final class Year
{
    private $year;

    public static function fromInt(int $year)
    {
        return new self($year);
    }

    public function __construct(int $year)
    {
        Assertion::true($year >= 0 && $year <= 9999, sprintf('Year must follow ISO-8601: %d.', $year));

        $this->year = $year;
    }

    public function equals(self $year): bool
    {
        return $this->year === $year->year;
    }

    public function isBefore(self $year): bool
    {
        return $this->year < $year->year;
    }

    public function isAfter(self $year): bool
    {
        return $this->year > $year->year;
    }

    public function isLeap(): bool
    {
        return ((($this->year % 4) == 0) && ((($this->year % 100) != 0) || (($this->year % 400) == 0)));
    }

    public function plusYears(int $years): self
    {
        Assertion::true($years >= 0);
        return new self($this->year + $years);
    }

    public function minusYears(int $years): self
    {
        Assertion::true($years >= 0);
        return new self($this->year - $years);
    }

    public function toInt(): int
    {
        return $this->year;
    }

    public function toString(): string
    {
        return sprintf('%04d', $this->year);
    }
}
