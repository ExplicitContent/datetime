<?php

namespace ExplicitContent\DateTime;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

/**
 *
 */
final class MoscowDateTime
{
    private $zoned;

    /**
     * This method is discouraged to be used often due to its "singleton-ish" nature.
     * Make sure you don't have chance to pass object from outside.
     */
    public static function now(): self
    {
        return new self(ZonedDateTime::fromNative(new DateTimeImmutable('now', new DateTimeZone('Europe/Moscow'))));
    }

    public static function fromYmdHis(string $date): self
    {
        return new self(ZonedDateTime::fromYmdHis($date, TimeZone::msk()));
    }

    public static function fromUnixTimestamp(int $ts): self
    {
        return new self(ZonedDateTime::fromUnixTimestamp($ts, TimeZone::msk()));
    }

    public static function fromNative(DateTimeInterface $dt): self
    {
        return new self(
            ZonedDateTime::fromNative(
                new DateTimeImmutable('@' . $dt->getTimestamp(), new DateTimeZone('Europe/Moscow'))
            )
        );
    }

    public static function fromZoned(ZonedDateTime $zoned): self
    {
        return new self(ZonedDateTime::fromUnixTimestamp($zoned->toUnixTimestamp(), TimeZone::msk()));
    }

    public static function fromUtc(UtcDateTime $utc): self
    {
        return self::fromZoned($utc->toZoned());
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

    public function toUtc(): UtcDateTime
    {
        return UtcDateTime::fromZoned(
            ZonedDateTime::fromUnixTimestamp(
                $this->zoned->toUnixTimestamp(),
                TimeZone::utc()
            )
        );
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

    public function toHumanReadableString(): string
    {
        return sprintf('%s MSK', $this->zoned->toYmdHis());
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
}
