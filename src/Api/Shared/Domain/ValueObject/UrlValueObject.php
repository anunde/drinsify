<?php

namespace App\Api\Shared\Domain\ValueObject;

abstract class UrlValueObject
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
        if (!\filter_var($value, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException(\sprintf('The url %s is invalid.', $value));
        }
    }
}