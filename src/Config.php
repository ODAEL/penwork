<?php
declare(strict_types=1);

namespace Penwork;

final class Config
{
    /** @var static */
    private static $instance;

    /** @var array */
    private $params;

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

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getParams(...$keys)
    {
        $params = $this->params;
        foreach ($keys as $key) {
            $params = $params[$key] ?? null;
        }
        return $params;
    }

}