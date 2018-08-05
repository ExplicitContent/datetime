<?php

namespace ExplicitContent\DateTime;

/**
 *
 */
final class LocalDateTime
{
    private $date;
    private $time;

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
}
