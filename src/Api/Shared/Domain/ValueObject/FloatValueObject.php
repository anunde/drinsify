<?php

namespace App\Api\Shared\Domain\ValueObject;

abstract class FloatValueObject
{
    public function __construct(protected float $value)
    {
        $this->ensureIsValidPrice($value);

        $this->value = $value;
    }

    public function value(): float
    {
        return $this->value;
    }

    private function ensureIsValidPrice(float $value): void
    {
        if ($value < 0) {
            throw new \InvalidArgumentException(sprintf('The price <%s> is not valid', $value));
        }
    }
}