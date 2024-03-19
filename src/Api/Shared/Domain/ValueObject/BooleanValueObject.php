<?php

namespace App\Api\Shared\Domain\ValueObject;

use http\Exception\InvalidArgumentException;

abstract class BooleanValueObject
{
    public function __construct(protected bool $value)
    {
        $this->isValid($this->value());

        return $this->value();
    }

    public function value(): bool
    {
        return $this->value;
    }

    private function isValid(bool $value): void
    {
        if (!\is_bool($value)) {
            throw new InvalidArgumentException(\sprintf('%s does not allow the value %s.', static::class, $value));
        }
    }
}