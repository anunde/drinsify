<?php

namespace App\Api\Shared\Domain\ValueObject;

abstract class IntegerValueObject
{
    public function __construct(protected int $value)
    {
        $this->isValid($this->value());

        return $this->value();
    }

    public function value(): int
    {
        return $this->value;
    }

    private function isValid(int $value): void
    {
        if (!\is_integer($value)) {
            throw new \InvalidArgumentException(\sprintf('%s does not allow the value %s.', static::class, $value));
        }
    }
}