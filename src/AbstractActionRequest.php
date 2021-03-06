<?php
declare(strict_types=1);

namespace Penwork;

use Penwork\Traits\ErrorTrait;

abstract class AbstractActionRequest
{
    use ErrorTrait;

    public function __construct()
    {
        $this->init();
        $this->validate();
    }

    private function validate(): void
    {
        if (!$this->hasErrors()) {
            $this->afterValidate();
        }
    }

    protected function getQueryParam(string $key, $default = null)
    {
        return $default !== null ? $_GET[$key] : ($_GET[$key] ?? $default);
    }

    protected function getQueryInteger(string $key, int $default = null): ?int
    {
        $param = $this->getQueryParam($key, $default);

        if (Validations::isInteger($param)) {
            return $param;
        }

        $this->addError("Param $key is not integer");

        return null;
    }

    protected function getQueryString(string $key, string $default = null): ?string
    {
        $param = $this->getQueryParam($key, $default);

        if (Validations::isString($param)) {
            return $param;
        }

        $this->addError("Param $key is not string");

        return null;
    }


    protected function getRequestParam(string $key, $default = null)
    {
        return $default !== null ? $_POST[$key] : ($_POST[$key] ?? $default);
    }

    protected function getRequestInteger(string $key, int $default = null): ?int
    {
        $param = $this->getRequestParam($key, $default);

        if (Validations::isInteger($param)) {
            return (int)$param;
        }

        $this->addError("Param $key is not integer");

        return null;
    }

    protected function getRequestString(string $key, string $default = null): ?string
    {
        $param = $this->getRequestParam($key, $default);

        if (Validations::isString($param)) {
            return $param;
        }

        $this->addError("Param $key is not string");

        return null;
    }

    protected function getRequestArray(string $key, string $default = null): ?array
    {
        $param = $this->getRequestParam($key, $default);

        if (Validations::isArray($param)) {
            return $param;
        }

        $this->addError("Param $key is not array");

        return null;
    }

    abstract protected function afterValidate(): void;

    abstract protected function init(): void;
}