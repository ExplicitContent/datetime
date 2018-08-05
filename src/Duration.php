<?php

namespace ExplicitContent\DateTime;

use DateInterval;
use Exception;
use ExplicitContent\Assertion\Assertion;
use LogicException;

/**
 * A time-based amount of time.
 * Duration is not connected to the time line, therefore units like "months" and "years" make no sense for this concept.
 *
 * Unlike Java 8 Duration, this concept does not keep information about units,
 * i.e. Duration::hours(2) and Duration::minutes(120) are the same in any sense.
 */
final class Duration
{
    private $seconds;

    public static function hours(int $hours): self
    {
        return new self($hours * 3600, false);
    }

    public static function minutes(int $minutes): self
    {
        return new self($minutes * 60, false);
    }

    public static function seconds(int $seconds): self
    {
        return new self($seconds, false);
    }

    /**
     * @param string $duration ISO-8601 format
     * @return Duration
     */
    public static function fromString(string $duration): self
    {
        try {
            $interval = new DateInterval($duration);
        } catch (Exception $e) {
            throw new LogicException(
                sprintf(
                    'Duration "%s" does not follow ISO-8601 format: "%s".',
                    $duration,
                    $e->getMessage()
                ),
                0,
                $e
            );
        }

        Assertion::true($interval->y === 0, 'Duration cannot contain years.');
        Assertion::true($interval->m === 0, 'Duration cannot contain months.');

        return new self(
            $interval->s + $interval->m * 60 + $interval->h * 3600 + $interval->d * 86400,
            $interval->invert === 1
        );
    }

    private function __construct(int $seconds)
    {
        $this->seconds = $seconds;
    }

    public function equals(self $duration): bool
    {
        return $this->seconds === $duration->seconds;
    }

    public function toAbsSeconds(): int
    {
        return abs($this->seconds);
    }

    public function toSeconds(): int
    {
        return $this->seconds;
    }

    public function isNegated(): bool
    {
        return $this->seconds < 0;
    }

    public function negated(): self
    {
        return new self(-$this->seconds);
    }

    public function plusSeconds(int $seconds): self
    {
        Assertion::true($seconds >= 0);
        return new self($this->seconds + $seconds);
    }

    public function minusSeconds(int $seconds): self
    {
        Assertion::true($seconds >= 0);
        return new self($this->seconds - $seconds);
    }

    public function plusMinutes(int $minutes): self
    {
        Assertion::true($minutes >= 0);
        return new self($this->seconds + $minutes * 60);
    }

    public function minusMinutes(int $minutes): self
    {
        Assertion::true($minutes >= 0);
        return new self($this->seconds - $minutes * 60);
    }

    public function plusHours(int $hours): self
    {
        Assertion::true($hours >= 0);
        return new self($this->seconds + $hours * 3600);
    }

    public function minusHours(int $hours): self
    {
        Assertion::true($hours >= 0);
        return new self($this->seconds + $hours * 3600);
    }
}
