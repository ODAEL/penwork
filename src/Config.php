<?php
declare(strict_types=1);

namespace Penwork;

use Penwork\Traits\SingletonTrait;
use RuntimeException;

final class Config
{
    use SingletonTrait;

    public const KEY_SYSTEM = 'sys';

    /** @var array */
    private $params;

    private function __construct()
    {
        // Cannot be called outside
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function mergeParams(array $params): void
    {
        $this->params = array_merge($this->params, $params);
    }

    public function getParams(...$keys)
    {
        $params = $this->params;
        foreach ($keys as $key) {
            $params = $params[$key] ?? null;
        }
        return $params;
    }

    public function getRequiredParams(...$keys)
    {
        $params = $this->getParams(...$keys);

        if ($params === null) {
            throw new RuntimeException('Cannot find required params');
        }

        return $params;
    }
}