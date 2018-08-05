<?php

namespace ExplicitContent\DateTime;

use DateTimeImmutable;
use DateTimeZone;
use ExplicitContent\Assertion\Assertion;
use LogicException;

/**
 *
 */
final class LocalDate
{
    private $date;

    public static function from(int $year, int $month, int $day): self
    {
        return new self($year, $month, $day);
    }

    public static function fromString(string $date): self
    {
        if (!preg_match('/^(?<year>\d{4})-(?<month>\d{2})-(?<day>\d{2})$/', $date, $match)) {
            throw new LogicException(sprintf('Date "%s" does not follow YYYY-MM-DD local date format.', $date));
        }

        return new self($match['year'], $match['month'], $match['day'] ?? 0);
    }

    private function __construct(int $year, int $month, int $day)
    {
        Assertion::true(checkdate($month, $day, $year), sprintf('Not a date: %04d-%02d-%02d', $year, $month, $day));

        $this->date = sprintf('%04d-%02d-%02d', $year, $month, $day);
    }

    public function equals(self $time): bool
    {
        return $this->date === $time->date;
    }

    public function isBefore(self $time): bool
    {
        return $this->date < $time->date;
    }

    public function isAfter(self $time): bool
    {
        return $this->date > $time->date;
    }

    public function getYear(): Year
    {
        return Year::fromInt((int)substr($this->date, 0, 4));
    }

    public function getMonth(): Month
    {
        return Month::fromInt((int)substr($this->date, 5, 2));
    }

    public function getDay(): int
    {
        return (int)substr($this->date, -2);
    }

    public function getDayOfYear(): int
    {
        return (int)($this->native()->format('z')) + 1;
    }

    public function plusDays(int $days): self
    {
        Assertion::true($days >= 0);
        return $this->modify(sprintf('+%d days', $days));
    }

    public function minusDays(int $days): self
    {
        Assertion::true($days >= 0);
        return $this->modify(sprintf('-%d days', $days));
    }

    public function plusWeeks(int $weeks): self
    {
        Assertion::true($weeks >= 0);
        return $this->modify(sprintf('+%d weeks', $weeks));
    }

    public function minusWeeks(int $weeks): self
    {
        Assertion::true($weeks >= 0);
        return $this->modify(sprintf('-%d weeks', $weeks));
    }

    public function plusMonths(int $months): self
    {
        Assertion::true($months >= 0);
        return $this->modify(sprintf('+%d months', $months));
    }

    public function minusMonths(int $months): self
    {
        Assertion::true($months >= 0);
        return $this->modify(sprintf('-%d months', $months));
    }

    public function plusYears(int $years): self
    {
        Assertion::true($years >= 0);
        return $this->modify(sprintf('+%d years', $years));
    }

    public function minusYears(int $years): self
    {
        Assertion::true($years >= 0);
        return $this->modify(sprintf('-%d years', $years));
    }

    public function toString(): string
    {
        return $this->date;
    }

    private function modify(string $modifyRule): self
    {
        return self::fromString($this->native()->modify($modifyRule)->format('Y-m-d'));
    }

    private function native(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->date, new DateTimeZone('UTC'));
    }
}
