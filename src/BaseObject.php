<?php
declare(strict_types=1);

namespace Penwork;

class BaseObject
{
    protected static function getConfigParams(string ...$keys)
    {
        return Config::getInstance()->getParams(...$keys);
    }

    protected static function getConfigRequiredParams(string ...$keys)
    {
        return Config::getInstance()->getRequiredParams(...$keys);
    }
}