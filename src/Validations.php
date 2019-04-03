<?php
declare(strict_types=1);

namespace Penwork;

class Validations
{
    public static function removeSpaces(string $string, $trim = true, $duplicates = true): string
    {
        if ($duplicates) {
            $string = preg_replace('/\s+/', ' ', $string);
        }

        if ($trim) {
            $string = trim($string);
        }

        return $string;
    }

    public static function isInteger($value): bool
    {
        return is_numeric($value);
    }

    public static function isString($value): bool
    {
        return is_string($value);
    }

    public static function isArray($value): bool
    {
        return is_array($value);
    }

}