<?php
declare(strict_types=1);

namespace Penwork\Traits;

trait ErrorTrait
{
    /** @var string[] */
    protected $errors = [];

    protected function addError(string $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getLastError(): ?string
    {
        return count($this->errors) !== 0 ? $this->errors[array_key_last($this->errors)] : null;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) !== 0;
    }
}