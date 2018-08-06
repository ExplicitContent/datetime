<?php

namespace ExplicitContent\DateTime;

use ExplicitContent\Assertion\Assertion;

/**
 *
 */
final class LocalDateTime
{
    private const FORMAT = '/^(?<Y>\d{4})-(?<m>\d{2})-(?<d>\d{2}) (?<H>\d{2}):(?<i>\d{2}):(?<s>\d{2})$/';

    private $date;
    private $time;

    public static function fromYmdHis(string $string): self
    {
        Assertion::true(preg_match(self::FORMAT, $string, $match) === 1, function () use ($string) {
            return sprintf('Date "%s" does not follow "Y-m-d H:i:s" format.', $string);
        });

        return new self(
            LocalDate::from($match['Y'], $match['m'], $match['d']),
            LocalTime::from($match['H'], $match['i'], $match['s'])
        );
    }

    public function __construct(LocalDate $date, LocalTime $time)
    {
        $this->date = $date;
        $this->time = $time;
    }

    public function getDate(): LocalDate
    {
        return $this->date;
    }

    public function getTime(): LocalTime
    {
        return $this->time;
    }

    public function toYmdHis(): string
    {
        return $this->date->toYmd() . ' ' . $this->time->toHis();
    }
}
