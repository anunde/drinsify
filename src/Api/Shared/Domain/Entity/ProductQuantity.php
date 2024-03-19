<?php

namespace App\Api\Shared\Domain\Entity;

use App\Api\Shared\Domain\ValueObject\IntegerValueObject;

class ProductQuantity extends IntegerValueObject
{
    public function __construct(int $value)
    {
        parent::__construct($value);
        $this->ensureIsValid($value);
    }

    private function ensureIsValid($value): void
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Product sold out');
        }
    }
}