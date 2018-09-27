<?php

namespace App\Utils;

class StringUtils
{
    /**
     * @param string $input
     *
     * @return string
     */
    public static function singularize(string $input): string
    {
        $lastLetter = $input[strlen($input) - 1];
        if ('s' === $lastLetter || 'S' === $lastLetter) {
            return substr_replace($input, '', -1);
        }

        return $input;
    }

    /**
     * @param string $input
     * @param bool   $capitalizeFirst
     *
     * @return string
     */
    public static function snakeToCamelCase(string $input, bool $capitalizeFirst = true): string
    {
        return self::camelize($input, '_', $capitalizeFirst);
    }

    /**
     * @param string $input
     * @param bool   $capitalizeFirst
     *
     * @return string
     */
    public static function dashesToCamelCase(string $input, bool $capitalizeFirst = true): string
    {
        return self::camelize($input, '-', $capitalizeFirst);
    }

    /**
     * @param string $input
     * @param string $separator
     * @param bool   $capitalizeFirst
     *
     * @return string
     */
    private static function camelize(string $input, string $separator, bool $capitalizeFirst): string
    {
        $string = str_replace($separator, '', ucwords($input, $separator));

        return $capitalizeFirst ? $string : lcfirst($string);
    }
}