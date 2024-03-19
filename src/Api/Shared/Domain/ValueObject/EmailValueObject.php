<?php

namespace App\Api\Shared\Domain\ValueObject;

abstract class EmailValueObject
{
    public function __construct(protected string $value)
    {
        $this->isValid($this->value());

        return $this->value();
    }

    public function value(): string
    {
        return $this->value;
    }

    private function isValid(string $value): void
    {
        if (!\filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(\sprintf('The email %s is invalid.', $value));
        }
    }
}