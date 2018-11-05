<?php

namespace App\Utils;

class Clock
{
    /**
     * @param string|int|null $pattern
     *
     * @return \DateTime
     */
    public static function now($pattern = null): \DateTime
    {
        return new \DateTime($pattern);
    }

    /**
     * @param string $pattern
     *
     * @return \DateTime
     */
    public static function relativeDate(string $pattern): \DateTime
    {
        return self::now($pattern);
    }

    /**
     * @return \DateTime
     */
    public static function today(): \DateTime
    {
        return self::relativeDate('today');
    }

    /**
     * @return \DateTime
     */
    public static function tomorrow(): \DateTime
    {
        return self::relativeDate('tomorrow');
    }
}