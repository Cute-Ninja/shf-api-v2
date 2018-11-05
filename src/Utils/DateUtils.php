<?php

namespace App\Utils;

class DateUtils
{
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public static function isPassed(\DateTime $date): bool
    {
        return $date < Clock::now();
    }
}