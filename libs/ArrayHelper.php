<?php
/**
 * Created by PhpStorm.
 * User: penko
 * Date: 26.08.2018
 * Time: 1:19
 */

namespace vendor\libs;


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