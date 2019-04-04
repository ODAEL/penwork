<?php
declare(strict_types=1);

namespace Penwork\Traits;

trait SingletonTrait
{
    /** @var static */
    private static $instance;

    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}