<?php
declare(strict_types=1);

namespace Penwork;

class BaseObject
{
    protected static function getConfigParams(string ...$keys)
    {
        return Config::getInstance()->getParams($keys);
    }

    protected static function getConfigRequiredParams(string ...$keys)
    {
        return Config::getInstance()->getRequiredParams($keys);
    }

    protected static function getSystemConfigParams(string ...$keys)
    {
        return Config::getInstance()->getParams(array_merge([Config::KEY_SYSTEM], $keys));
    }

    protected static function getSystemConfigRequiredParams(string ...$keys)
    {
        return Config::getInstance()->getRequiredParams(array_merge([Config::KEY_SYSTEM], $keys));
    }
}