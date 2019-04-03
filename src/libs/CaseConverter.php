<?php

namespace Penwork\libs;

class CaseConverter
{
    public const UPPER_CAMEL_CASE = 1;
    public const LOWER_CAMEL_CASE = 2;

    public const NORMAL_SNAKE_CASE = 1;
    public const DEFIS_SNAKE_CASE  = 2;


    public static function camelCaseDecode(string $string = null, int $type = null): ?array
    {
        if ($string === null) {
            return [];
        }

        switch ($type) {

            case self::UPPER_CAMEL_CASE:
                preg_match_all('/[A-Z][a-z]*/', $string, $matches);
                $result = $matches[0];
                break;

            case self::LOWER_CAMEL_CASE:
                preg_match('/([a-z]+)([A-Z][A-Z,a-z]*)?/', $string, $matches);
                $rightSide = self::camelCaseDecode($matches[2], self::UPPER_CAMEL_CASE);
                $result = array_merge([$matches[1]], $rightSide);
                break;

            case null:
                if (ctype_lower($string[0])) {
                    return self::camelCaseDecode($string, self::LOWER_CAMEL_CASE);
                }

                if (ctype_upper($string[0])) {
                    return self::camelCaseDecode($string, self::UPPER_CAMEL_CASE);
                }
                return null;
                break;

            default:
                return null;
                break;
        }

        foreach ($result as &$item) {
            $item = strtolower($item);
        }

        return $result;
    }

    public static function camelCaseEncode(array $array, int $type = self::UPPER_CAMEL_CASE): string
    {
        foreach ($array as &$item) {
            $item = ucfirst($item);
        }

        unset($item);

        if ($type === self::LOWER_CAMEL_CASE) {
            $array[0] = lcfirst($array[0]);
        }

        return implode($array);
    }

    public static function snakeCaseDecode(string $string): array
    {
        $result = preg_split('/[_,-]/', $string);

        foreach ($result as &$item) {
            $item = strtolower($item);
        }

        unset($item);

        return $result;
    }

    public static function snakeCaseEncode(array $array, int $type = self::NORMAL_SNAKE_CASE): string
    {
        if ($type === self::DEFIS_SNAKE_CASE) {
            return implode('-', $array);
        }

        return implode('_', $array);
    }

}