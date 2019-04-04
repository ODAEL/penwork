<?php
declare(strict_types=1);

namespace Penwork\Traits;

trait SingletonTrait
{
    /** @var static */
    private static $instance;

    private function __construct()
    {
        // Cannot be called outside
    }

    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}