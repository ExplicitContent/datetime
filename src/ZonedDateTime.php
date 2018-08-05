<?php

namespace ExplicitContent\DateTime;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use ExplicitContent\Assertion\Assertion;

/**
 *
 */
final class ZonedDateTime
{
    private $dt;

    public static function fromYmdHis(string $date, TimeZone $tz): self
    {
        $dt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $date, $tz->toNative());

        Assertion::true($dt !== false, sprintf('Date does not follow "Y-m-d H:i:s" format: "%s".', $date));

        return new self($dt);
    }

    public static function fromUnixTimestamp(int $ts, TimeZone $tz): self
    {
        return new self(new DateTimeImmutable('@' . $ts, $tz->toNative()));
    }

    public static function fromNative(DateTimeInterface $dt): self
    {
        return new self(new DateTimeImmutable('@' . $dt->getTimestamp(), $dt->getTimezone()));
    }

    private function __construct(DateTimeImmutable $datetime)
    {
        $this->dt = $datetime;
    }

    public function equals(self $dateTime): bool
    {
        return $this->dt == $dateTime->dt;
    }

    public function toYmdHis(): string
    {
        return $this->dt->format('Y-m-d H:i:s');
    }

    public function toUnixTimestamp(): int
    {
        return $this->dt->getTimestamp();
    }

    public function toNative(): DateTimeImmutable
    {
        return $this->dt;
    }

    public function toRfc3399(): string
    {
        return $this->dt->format(DateTime::RFC3339);
    }

    public function toRfc3399WithMicroseconds(): string
    {
        return $this->dt->format(DateTime::RFC3339_EXTENDED);
    }

    public function toLocalDate(): LocalDate
    {
        return LocalDate::fromString($this->dt->format('Y-m-d'));
    }

    public function toLocalTime(): LocalTime
    {
        return LocalTime::fromString($this->dt->format('H:i:s'));
    }

    public function toDayOfWeek(): DayOfWeek
    {
        return DayOfWeek::fromInt((int)$this->dt->format('w'));
    }

    public function toMonth(): Month
    {
        return Month::fromInt((int)$this->dt->format('m'));
    }

    public function isBefore(self $dateTime): bool
    {
        return $this->dt < $dateTime->dt;
    }

    public function isAfter(self $dateTime): bool
    {
        return $this->dt > $dateTime->dt;
    }

    public function diff(self $dateTime): Duration
    {
        return Duration::seconds($this->dt->getTimestamp() - $dateTime->dt->getTimestamp());
    }

    /**
     * @param ZonedDateTime $dateTime
     * @return int May be negative.
     */
    public function getYearsDiff(self $dateTime): int
    {
        $diff = $this->dt->diff($dateTime->dt);
        return $diff->invert ? -$diff->y : $diff->y;
    }

    /**
     * @param ZonedDateTime $dateTime
     * @return int May be negative.
     */
    public function getSecondsDiff(self $dateTime): int
    {
        return $this->dt->getTimestamp() - $dateTime->dt->getTimestamp();
    }

    /**
     * @param ZonedDateTime $dateTime
     * @return int May be negative.
     */
    public function getMinutesDiff(self $dateTime): int
    {
        return intval(($this->dt->getTimestamp() - $dateTime->dt->getTimestamp()) / 60);
    }

    public function shift(Duration $duration): self
    {
        if ($duration->isNegated()) {
            return $this->plusSeconds($duration->toAbsSeconds());
        } else {
            return $this->minusSeconds($duration->toAbsSeconds());
        }
    }

    public function plusSeconds(int $seconds): self
    {
        self::assertNonNegative($seconds);
        return new self($this->toNative()->add(new DateInterval(sprintf('PT%dS', $seconds))));
    }

    public function minusSeconds(int $seconds): self
    {
        self::assertNonNegative($seconds);
        return new self($this->dt->sub(new DateInterval(sprintf('PT%dS', $seconds))));
    }

    public function plusMinutes(int $minutes): self
    {
        self::assertNonNegative($minutes);
        return new self($this->toNative()->add(new DateInterval(sprintf('PT%dM', $minutes))));
    }

    public function minusMinutes(int $minutes): self
    {
        self::assertNonNegative($minutes);
        return new self($this->dt->sub(new DateInterval(sprintf('PT%dM', $minutes))));
    }

    public function plusHours(int $hours): self
    {
        self::assertNonNegative($hours);
        return new self($this->toNative()->add(new DateInterval(sprintf('PT%dH', $hours))));
    }

    public function minusHours(int $hours): self
    {
        self::assertNonNegative($hours);
        return new self($this->dt->sub(new DateInterval(sprintf('PT%dH', $hours))));
    }

    public function plusDays(int $days): self
    {
        self::assertNonNegative($days);
        return new self($this->dt->add(new DateInterval(sprintf('P%dD', $days))));
    }

    public function minusDays(int $days): self
    {
        self::assertNonNegative($days);
        return new self($this->dt->sub(new DateInterval(sprintf('P%dD', $days))));
    }

    public function plusWeeks(int $weeks): self
    {
        self::assertNonNegative($weeks);
        return new self($this->dt->modify(sprintf('+%d week', $weeks)));
    }

    public function minusWeeks(int $weeks): self
    {
        self::assertNonNegative($weeks);
        return new self($this->dt->modify(sprintf('-%d week', $weeks)));
    }

    public function plusMonths(int $months): self
    {
        self::assertNonNegative($months);
        return new self($this->dt->modify(sprintf('+%d month', $months)));
    }

    public function minusMonths(int $months): self
    {
        self::assertNonNegative($months);
        return new self($this->dt->modify(sprintf('-%d month', $months)));
    }

    public function plusYears(int $years): self
    {
        self::assertNonNegative($years);
        return new self($this->dt->modify(sprintf('+%d year', $years)));
    }

    public function minusYears(int $years): self
    {
        self::assertNonNegative($years);
        return new self($this->dt->modify(sprintf('-%d year', $years)));
    }

    private static function assertNonNegative(int $value): void
    {
        Assertion::true($value > 0, 'Negative number is not allowed, use one of the plus*/minus*() methods.');
    }
}
