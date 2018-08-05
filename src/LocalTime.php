<?php

namespace ExplicitContent\DateTime;

/**
 * It does not support time with leap second (23:60) and 24:00 notation.
 */
final class LocalTime
{
    private $secondOfDay;

    public static function from(int $hour, int $minute, int $second): self
    {
        if ($hour < 0 || $hour > 23 || $minute < 0 || $minute > 59 || $second < 0 || $second > 59) {
            throw new \LogicException(sprintf('Wrong time: %02d:%02d:%02d', $hour, $minute, $second));
        }

        return new self($hour * 3600 + $minute * 60 + $second);
    }

    public static function fromSecondOfDay(int $second): self
    {
        if ($second < 0 || $second > 86400) {
            throw new \LogicException(sprintf('Meaningless number of second of day for local time: %d.', $second));
        }

        return self::fromSeconds($second);
    }

    public static function fromString(string $time): self
    {
        $parsed = self::parse($time);

        return self::from($parsed['hour'], $parsed['minute'], $parsed['second']);
    }

    private function __construct(int $secondOfDay)
    {
        $this->secondOfDay = $secondOfDay;
    }

    public function equals(self $time): bool
    {
        return $this->secondOfDay === $time->secondOfDay;
    }

    public function isBefore(self $time): bool
    {
        return $this->secondOfDay < $time->secondOfDay;
    }

    public function isAfter(self $time): bool
    {
        return $this->secondOfDay > $time->secondOfDay;
    }

    public function toSecondsOfDay(): int
    {
        return $this->secondOfDay;
    }

    public function shift(Duration $duration): self
    {
        return self::fromSeconds($this->secondOfDay + $duration->toSeconds());
    }

    public function plusSeconds(int $seconds): self
    {
        self::assertNonNegative($seconds);
        return self::fromSeconds($this->secondOfDay + $seconds);
    }

    public function minusSeconds(int $seconds): self
    {
        self::assertNonNegative($seconds);
        return self::fromSeconds($this->secondOfDay - $seconds);
    }

    public function plusMinutes(int $minutes): self
    {
        self::assertNonNegative($minutes);
        return self::fromSeconds($this->secondOfDay + $minutes * 60);
    }

    public function minusMinutes(int $minutes): self
    {
        self::assertNonNegative($minutes);
        return self::fromSeconds($this->secondOfDay - $minutes * 60);
    }

    public function plusHours(int $hours): self
    {
        self::assertNonNegative($hours);
        return self::fromSeconds($this->secondOfDay + $hours * 3600);
    }

    public function minusHours(int $hours): self
    {
        self::assertNonNegative($hours);
        return self::fromSeconds($this->secondOfDay - $hours * 3600);
    }

    private static function fromSeconds(int $seconds): self
    {
        $seconds = ($seconds % 86400);

        if ($seconds < 0) {
            $seconds += abs($seconds);
        }

        return new self($seconds);
    }

    private static function parse(string $time): array
    {
        if (!preg_match('/^(?<hour>\d{2}):(?<minute>\d{2})(?::(?<second>\d{2}))?$/', $time, $match)) {
            throw new \LogicException(sprintf('Time must respect ISO-8601 local time format.'));
        }

        return $match;
    }

    private static function assertNonNegative(int $value): void
    {
        if ($value < 0) {
            throw new \LogicException('Negative number is not allowed, use one of the proper plus/minus methods.');
        }
    }
}
