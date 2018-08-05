<?php

namespace ExplicitContent\DateTime;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

/**
 *
 */
final class UtcDateTime
{
    private $zoned;

    /**
     * This method is discouraged to be used often due to its "singleton-ish" nature.
     * Make sure you don't have chance to pass object from outside.
     */
    public static function now(): self
    {
        return new self(ZonedDateTime::fromNative(new DateTimeImmutable('now', new DateTimeZone('UTC'))));
    }

    public static function fromYmdHis(string $date): self
    {
        return new self(ZonedDateTime::fromYmdHis($date, TimeZone::utc()));
    }

    public static function fromUnixTimestamp(int $ts): self
    {
        return new self(ZonedDateTime::fromUnixTimestamp($ts, TimeZone::utc()));
    }

    public static function fromNative(DateTimeInterface $dt): self
    {
        return new self(
            ZonedDateTime::fromNative(
                new DateTimeImmutable('@' . $dt->getTimestamp(), new DateTimeZone('UTC'))
            )
        );
    }

    public static function fromZoned(ZonedDateTime $zoned): self
    {
        return new self($zoned);
    }

    private function __construct(ZonedDateTime $zoned)
    {
        $this->zoned = $zoned;
    }

    public function equals(self $dateTime): bool
    {
        return $this->zoned->equals($dateTime->zoned);
    }

    public function toYmdHis(): string
    {
        return $this->zoned->toYmdHis();
    }

    public function toUnixTimestamp(): int
    {
        return $this->zoned->toUnixTimestamp();
    }

    public function toNative(): DateTimeImmutable
    {
        return $this->zoned->toNative();
    }

    public function toZoned(): ZonedDateTime
    {
        return $this->zoned;
    }

    public function toRfc3399(): string
    {
        return $this->zoned->toRfc3399();
    }

    public function toRfc3399WithMicroseconds(): string
    {
        return $this->zoned->toRfc3399WithMicroseconds();
    }

    public function toLocalDate(): LocalDate
    {
        return $this->zoned->toLocalDate();
    }

    public function toLocalTime(): LocalTime
    {
        return $this->zoned->toLocalTime();
    }

    public function toDayOfWeek(): DayOfWeek
    {
        return $this->zoned->toDayOfWeek();
    }

    public function toMonth(): Month
    {
        return $this->zoned->toMonth();
    }

    public function isBefore(self $dateTime): bool
    {
        return $this->zoned->isBefore($dateTime->zoned);
    }

    public function isAfter(self $dateTime): bool
    {
        return $this->zoned->isAfter($dateTime->zoned);
    }

    public function diff(self $dateTime): Duration
    {
        return $this->zoned->diff($dateTime->zoned);
    }

    public function getYearsDiff(self $dateTime): int
    {
        return $this->zoned->getYearsDiff($dateTime->zoned);
    }

    public function getSecondsDiff(self $dateTime): int
    {
        return $this->zoned->getSecondsDiff($dateTime->zoned);
    }

    public function getMinutesDiff(self $dateTime): int
    {
        return $this->zoned->getMinutesDiff($dateTime->zoned);
    }

    public function shift(Duration $duration): self
    {
        return new self($this->zoned->shift($duration));
    }

    public function plusSeconds(int $seconds): self
    {
        return new self($this->zoned->plusSeconds($seconds));
    }

    public function minusSeconds(int $seconds): self
    {
        return new self($this->zoned->minusSeconds($seconds));
    }

    public function plusHours(int $hours): self
    {
        return new self($this->zoned->plusHours($hours));
    }

    public function minusHours(int $hours): self
    {
        return new self($this->zoned->minusHours($hours));
    }

    public function plusDays(int $days): self
    {
        return new self($this->zoned->plusDays($days));
    }

    public function minusDays(int $days): self
    {
        return new self($this->zoned->minusDays($days));
    }

    public function plusWeeks(int $weeks): self
    {
        return new self($this->zoned->plusWeeks($weeks));
    }

    public function minusWeeks(int $weeks): self
    {
        return new self($this->zoned->minusWeeks($weeks));
    }

    public function plusMonths(int $months): self
    {
        return new self($this->zoned->plusMonths($months));
    }

    public function minusMonths(int $months): self
    {
        return new self($this->zoned->plusMonths($months));
    }

    public function plusYears(int $years): self
    {
        return new self($this->zoned->plusYears($years));
    }

    public function minusYears(int $years): self
    {
        return new self($this->zoned->minusYears($years));
    }
}
