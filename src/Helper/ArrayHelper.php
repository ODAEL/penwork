<?php
declare(strict_types=1);

namespace Penwork\Helper;


class ArrayHelper
{
    public static function arrayAssociate(array $array, string $associatedKey): array
    {
        $array = array_filter($array,
            function ($item) use ($associatedKey) {
                return isset($item[$associatedKey]);
            });

        $newArray = [];
        foreach ($array as $item) {
            $newArray[$item[$associatedKey]] = $item;
        }

        return $newArray;
    }
}