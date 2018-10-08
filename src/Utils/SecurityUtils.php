<?php

namespace App\Utils;

class SecurityUtils
{
    /**
     * @param int|null $length
     *
     * @return string
     */
    public static function randomString(?int $length = 10): string
    {
        return bin2hex(random_bytes($length));
    }
}