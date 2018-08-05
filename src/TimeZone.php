<?php

namespace ExplicitContent\DateTime;

use DateTimeZone;

/**
 *
 */
final class TimeZone
{
    private $tz;

    public static function utc(): self
    {
        return new self(new DateTimeZone('UTC'));
    }

    public static function msk(): self
    {
        return new self(new DateTimeZone('Europe/Moscow'));
    }

    public static function fromNative(DateTimeZone $tz): self
    {
        return new self($tz);
    }

    private function __construct(DateTimeZone $tz)
    {
        $this->tz = $tz;
    }

    public function toNative(): DateTimeZone
    {
        return $this->tz;
    }
}
